<?php

namespace ITM\MagB1\Model\Customer;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use ITM\MagB1\Api\Customer\AccountManagementInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Stdlib\StringUtils as StringHelper;
use Magento\Framework\Encryption\EncryptorInterface as Encryptor;
use Magento\Framework\Exception\InputException;

class AccountManagement extends \Magento\Customer\Model\AccountManagement implements AccountManagementInterface
{
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var \Magento\Customer\Api\CustomerRepositoryInterface
     */
    private $customerRepository;


    protected $_objectManager;


    /**
     * @var StringHelper
     */
    protected $stringHelper;


    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $scopeConfig;


    /**
     * @var Encryptor
     */
    private $encryptor;


    /**
     * @var \Magento\Customer\Model\AuthenticationInterface
     */
    protected $authentication;

    /**
     * @var \Magento\Customer\Model\CustomerRegistry
     */
    private $customerRegistry;


    /**
     * @var \Magento\Framework\Session\SessionManagerInterface
     */
    private $sessionManager;



    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
        StringHelper $stringHelper,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Customer\Model\CustomerRegistry $customerRegistry,
        Encryptor $encryptor,
        \Magento\Framework\Session\SessionManagerInterface $sessionManager = null,
        \Magento\Framework\ObjectManagerInterface $objectManager
    ) {
        $this->storeManager = $storeManager;
        $this->customerRepository = $customerRepository;
        $this->_objectManager = $objectManager;

        $this->sessionManager = $sessionManager
            ?: ObjectManager::getInstance()->get(SessionManagerInterface::class);
            $this->stringHelper = $stringHelper;
        $this->scopeConfig = $scopeConfig;
        $this->customerRegistry = $customerRegistry;
        $this->encryptor = $encryptor;
    }

    /**
     * Retrieve minimum password length
     *
     * @return int
     */
    protected function getMinPasswordLength()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_MINIMUM_PASSWORD_LENGTH);
    }

    /**
     * Check password for presence of required character sets
     *
     * @param string $password
     * @return int
     */
    protected function makeRequiredCharactersCheck($password)
    {
        $counter = 0;
        $requiredNumber = $this->scopeConfig->getValue(self::XML_PATH_REQUIRED_CHARACTER_CLASSES_NUMBER);
        $return = 0;

        if (preg_match('/[0-9]+/', $password)) {
            $counter++;
        }
        if (preg_match('/[A-Z]+/', $password)) {
            $counter++;
        }
        if (preg_match('/[a-z]+/', $password)) {
            $counter++;
        }
        if (preg_match('/[^a-zA-Z0-9]+/', $password)) {
            $counter++;
        }

        if ($counter < $requiredNumber) {
            $return = $requiredNumber;
        }

        return $return;
    }

    /**
     * Create a hash for the given password
     *
     * @param string $password
     * @return string
     */
    protected function createPasswordHash($password)
    {
        return $this->encryptor->getHash($password, true);
    }

    /**
     * Get authentication
     *
     * @return AuthenticationInterface
     */
    private function getAuthentication()
    {
        if (!($this->authentication instanceof AuthenticationInterface)) {
            return \Magento\Framework\App\ObjectManager::getInstance()->get(
                \Magento\Customer\Model\AuthenticationInterface::class
            );
        } else {
            return $this->authentication;
        }
    }


    /**
     * {@inheritdoc}
     */
    public function changePassword($email, $newPassword, $websiteId = null)
    {

        if ($websiteId === null) {
            $websiteId = $this->storeManager->getStore()->getWebsiteId();
        }

        try {
            // load customer by email
            $customer = $this->customerRepository->get($email, $websiteId);
            $this->checkPasswordDifferentFromEmail(
                $email,
                $newPassword
            );
            $this->checkPasswordStrength($newPassword);
            //Update secure data
            $customerSecure = $this->customerRegistry->retrieveSecureData($customer->getId());
            $customerSecure->setRpToken(null);
            $customerSecure->setRpTokenCreatedAt(null);
            $customerSecure->setPasswordHash($this->createPasswordHash($newPassword));
            $this->getAuthentication()->unlock($customer->getId());
            $this->sessionManager->destroy();
            $this->customerRepository->save($customer);
            return true;
        } catch (\Exception $e) {
            throw new \Magento\Framework\Exception\InputException(__($e->getMessage()));
        }


        return false;
    }

    /**
     * Check that password is different from email.
     *
     * @param string $email
     * @param string $password
     * @return void
     * @throws InputException
     */
    public function checkPasswordDifferentFromEmail($email, $password)
    {
        if (strcasecmp($password, $email) == 0) {
            throw new \Magento\Framework\Exception\InputException(__('Password cannot be the same as email address.'));
        }
    }
}

