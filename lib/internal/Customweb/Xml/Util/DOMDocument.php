<?php

/**
 *  * You are allowed to use this API in your web application.
 *
 * Copyright (C) 2018 by customweb GmbH
 *
 * This program is licenced under the customweb software licence. With the
 * purchase or the installation of the software in your application you
 * accept the licence agreement. The allowed usage is outlined in the
 * customweb software licence which can be found under
 * http://www.sellxed.com/en/software-license-agreement
 *
 * Any modification or distribution is strictly forbidden. The license
 * grants you the installation in one application. For multiuse you will need
 * to purchase further licences at http://www.sellxed.com/shop.
 *
 * See the customweb software licence agreement for more details.
 *
 */


final class Customweb_Xml_Util_DOMDocument {

	/**
	 * Creates an XML document based on the given xml string.
	 *
	 * @param unknown $originalXmlString
	 * @param string $nsHost
	 */
	public static function loadXmlWithRelativeNamespaces($originalXmlString, $nsHost = "https://data.customweb.com/"){
		$modifiedXmlString = self::absolutizeNamespaces($originalXmlString, $nsHost);
		$tempDoc = new DOMDocument();
		$tempDoc->loadXML($modifiedXmlString);
		return self::relativizeNamespaces($tempDoc);
	}

	/**
	 * Replaces any absolute namespaces which start with $nsHost with the original relative namespaces.
	 *
	 * @param DOMDocument $oldDoc
	 * @param string $nsHost
	 * @return DOMDocument
	 */
	public static function relativizeNamespaces(DOMDocument $oldDoc, $nsHost = "https://data.customweb.com/"){
		$newDoc = new DOMDocument();
		
		if ($oldDoc->hasChildNodes()) {
			foreach ($oldDoc->childNodes as $child) {
				$newDoc->appendChild(self::createElementWithRelativeNamespace($newDoc, $child, $nsHost));
			}
		}
		
		return $newDoc;
	}

	/**
	 * Makes all namespaces used in the referenced string absolute URIs if they are not already.
	 * The namespace is prepended with the given $host.
	 *
	 * @param string $xmlString
	 * @param string $host
	 * @return string
	 */
	public static function absolutizeNamespaces($xmlString, $nsHost = "https://data.customweb.com/"){
		// Pattern description:
		// Find all namespace declarations where the given namespace is not an absolute URI.
		// Absolute URI is currently defined as being prefixed with http/s
		// Only capture groups where necessary - specify all others as non-capturing
		// Capture groups are:
		// (1): xmlns + namespace prefix
		// (2): namespace delimiter (" or ')
		// (3): namespace
		// Explanation:
		// Capture Group 1
		// - Exact check for xmlns
		// - Lazy check for prefix
		// Capture Group 2
		// - Exact check for delimiter (' or ")
		// Capture Group 3
		// - Exact check for protocol (http / https)
		// - Lazy check for namespace
		// Exact check for delimiter (backreference capture group 2)
		$pattern = "#((?:xmlns)(?:(?::)(?:(?:\w)+?))?(?:\s)*(?:=))(?:\s)*(\"|')(?!(?:http)(?:s)?(?:://))((?:.)+?)(?:\\2)#i";
		$replacement = "\\1\\2" . $nsHost . "\\3\\2";
		$newXml = preg_replace($pattern, $replacement, $xmlString);
		if ($newXml === null) {
			$error = self::getLastPregError();
			throw new Exception("An error occurred during the replacement of the namespaces: " . $error);
		}
		return $newXml;
	}

	/**
	 * Copies the element recursively, and removes any mention of $host in the given namespaces.
	 *
	 * @param DOMDocument $doc The new document into which the elements shall be loaded.
	 * @param DOMElement $original An element which should be recursively recreated with a new namespace
	 * @param string $host
	 * @return DOMElement
	 */
	private static function createElementWithRelativeNamespace(DOMDocument $doc, DOMElement $original, $host){
		$namespace = $original->namespaceURI;
		if (!empty($namespace)) {
			if (strpos($namespace, $host) === 0) {
				$namespace = substr($namespace, strlen($host));
			}
			$newElement = $doc->createElementNS($namespace, $original->tagName);
		}
		else {
			$newElement = $doc->createElement($original->tagName);
		}
		if (empty($newElement->parentNode)) {
			$doc->appendChild($newElement);
		}
		
		if ($original->hasAttributes()) {
			foreach ($original->attributes as $attribute) {
				$namespace = $attribute->namespaceURI;
				if (!empty($namespace)) {
					if (strpos($namespace, $host) === 0) {
						$namespace = substr($namespace, strlen($host));
					}
					$newAttribute = $doc->createAttributeNS($namespace, $attribute->name);
				}
				else {
					$newAttribute = $doc->createAttribute($attribute->name);
				}
				
				$newAttribute->value = $attribute->value;
				$newElement->appendChild($newAttribute);
			}
		}
		
		if ($original->childNodes->length) {
			foreach ($original->childNodes as $node) {
				if ($node instanceof DOMElement) {
					$newElement->appendChild(self::createElementWithRelativeNamespace($doc, $node, $host));
				}
				else if ($node instanceof DOMText) {
					$text = $doc->createTextNode($node->textContent);
					$newElement->appendChild($text);
				}
			}
		}
		
		return $newElement;
	}

	/**
	 * Attempts to create a string representation of the last occurred preg error.
	 * (Non localized)
	 *
	 * @return string
	 */
	private static function getLastPregError(){
		$error = preg_last_error();
		if ($error == PREG_NO_ERROR) {
			return "No error";
		}
		else if ($error == PREG_INTERNAL_ERROR) {
			return "Internal error";
		}
		else if ($error == PREG_BACKTRACK_LIMIT_ERROR) {
			return "Backtrack limit error";
		}
		else if ($error == PREG_RECURSION_LIMIT_ERROR) {
			return "Recursion limit error";
		}
		else if ($error == PREG_BAD_UTF8_ERROR) {
			return "Bad UTF8";
		}
		else if (defined('PREG_BAD_UTF8_OFFSET_ERROR') && $error == PREG_BAD_UTF8_OFFSET_ERROR) {
			// PHP 5.3
			return "Bad UTF8 offset";
		}
		else if (defined('PREG_JIT_STACKLIMIT_ERROR') && $error == PREG_JIT_STACKLIMIT_ERROR) {
			// PHP 7.0
			return "Jit stacklimit error";
		}
		else {
			return "Unknown error code: " . $error;
		}
	}
}