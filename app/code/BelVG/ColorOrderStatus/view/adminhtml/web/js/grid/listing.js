/**
 * BelVG LLC.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://store.belvg.com/BelVG-LICENSE-COMMUNITY.txt
 *
 ********************************************************************
 * @category   BelVG
 * @package    BelVG_ColorOrderStatus
 * @copyright  Copyright (c) BelVG LLC. (http://www.belvg.com)
 * @license    http://store.belvg.com/BelVG-LICENSE-COMMUNITY.txt
 */
define([], function () {
    'use strict';

    var mixin = {
        defaults: {
            template: 'BelVG_ColorOrderStatus/ui/grid/listing'
        },
        getRowStyle: function (row) {
            var styles='';

            if(row.color_order!='')
                styles =  'background: '+row.color_order;
            else
                styles = '';

            return styles;
        }
    };

    return function(target) {
        return target.extend(mixin);
    };

});