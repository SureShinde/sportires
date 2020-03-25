<?php
namespace Potato\Compressor\Plugin;

use Potato\Compressor\Model\Config;
use Potato\Compressor\Model\Optimisation\Processor;
use Potato\Compressor\Helper\Log as LogHelper;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\App\Response\Http as ResponseHttp;
use Potato\Compressor\Model\RequireJsManager;
use Potato\Compressor\Helper\HtmlParser;
use Magento\Framework\App\RequestInterface;

class ControllerRenderResultAfter
{
    /** @var Config  */
    protected $config;

    /** @var Processor  */
    protected $processor;

    /** @var LogHelper  */
    protected $logHelper;

    /** @var RequireJsManager  */
    protected $requireJsManager;

    /** @var RequestInterface */
    protected $request;

    /**
     * ProcessResponse constructor.
     * @param Config $config
     * @param Processor $processor
     * @param LogHelper $logHelper
     * @param RequireJsManager $requireJsManager
     * @param RequestInterface $request
     */
    public function __construct(
        Config $config,
        Processor $processor,
        LogHelper $logHelper,
        RequireJsManager $requireJsManager,
        RequestInterface $request
    ) {
        $this->config = $config;
        $this->processor = $processor;
        $this->logHelper = $logHelper;
        $this->requireJsManager = $requireJsManager;
        $this->request = $request;
    }

    /**
     * FPC will be called on afterRenderResult
     *
     * @param ResultInterface $subject
     * @param \Closure $proceed
     * @param ResponseHttp $response
     * @return \Magento\Framework\View\Result\Layout
     */
    public function aroundRenderResult(
        ResultInterface $subject,
        \Closure $proceed,
        ResponseHttp $response
    ) {
        $result = $proceed($response);
        if (!$this->config->isEnabled() || !HtmlParser::isHtml($response->getBody())) {
            return $result;
        }
        if (!($this->request instanceof \Magento\Framework\App\Request\Http)) {
            return $result;
        }
        $originalPathInfo = $this->request->getOriginalPathInfo();
        foreach ($this->config->getExcludeRouters() as $route) {
            if (strpos($originalPathInfo, $route) === 0) {
                return $result;
            }
        }
        try {
            $this->requireJsManager->aroundControllerRenderResultCall($response);
            $this->processor->processHtmlResponse($response);
        } catch (\Exception $e) {
            $this->logHelper->processorLog($e->getMessage());
        }
        return $result;
    }
}