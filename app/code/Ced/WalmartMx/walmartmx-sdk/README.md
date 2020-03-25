# walmartmx-sdk
WalmartMx marketplace api integration sdk
+ Sand box seller panel
   https://catch-dev.mirakl.net
+ Sand box url
    https://catch-dev.mirakl.net
    
# User Guide
### Installation
+ ##### Manual Way 
    + Create "cedcoss" directory in vendor directory
    + run below command in cedcoss directory
                        
            git clone https://github.com/cedcoss/catch-sdk.git
    + now open composer.json present in root directory and add below lines in it
    
            "autoload": {
                 "psr-4": {
                "WalmartMxSdk\\": "vendor/cedcoss/catch-sdk/src/"
                }
            }
    + after that run below command
    
            composer update
    
+ ##### Install through composer 
    + Run Below commands in your root directory (Make sure ssh key setup is done fore this repo)
    
            composer config repositories.cedcoss/catch-sdk git git@github.com:cedcoss/catch-sdk.git
            
            composer require cedcoss/catch-sdk:dev-master
            
            
            
            
### WalmartMx Integration guide:
#### Product:
* All Required common product attributes:
    ```
    [
        "title",
        "short-desc",
        "item-class",
        "standard-price",
        "brand",
        "shipping-length",
        "shipping-width",
        "shipping-height",
        "shipping-weight",
        "offer-condition/condition",
        "item-id",
        "model-number",
        "image-url",
        "standard-price"
    ]
    
    ```
* Some optional common product attributes:
    ```
    [
        "upc", 
        "mature-content",
        "your-categorization",
        "long-desc",
        "manufacturer-name",
        "map-price-indicator",
        "no-warranty-available",
        "gift-message-eligible"
    ]
    
    ```
    
* **Note**:
    + Change in **"item-id"**, **"upc"** or **"model-number"** attributes will lead to creation of **new** product on catch.
    + UPC is required for certain categories. Kindly refer: https://www.catchcommerceservices.com/question/in-which-categories-do-i-need-to-provide-a-upc/
            
    Refer to [lmp-item.xsd](https://github.com/cedcoss/walmartmx-sdk/blob/dev/xsd/lmp-item.xsd "lmp-item.xsd")

    Kindly read: https://www.catchcommerceservices.com/faq/
