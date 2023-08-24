require(
    [
        'jquery',
        'handlebars'
    ],
    function (
        jQueryMain,
        HandlebarsMain,
    ) {
        window.Handlebars=HandlebarsMain;
        var jsfiles = ["https://www-staging.downies.com/static/version1658823834/frontend/Collectables/base/en_AU/Unbxd_SearchJs/js/search.js"];

        jsfiles.forEach(function(file,index) {
            var s1 = document.createElement('script');
            s1.type = 'text/javascript';

            s1.src = file;
            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(s1);

        });
        jQueryMain(document).ready(function(){
            window.magento_unbxd_listingconfig={
                searchBoxSelector: document.getElementById("search"),
                searchTrigger: "click",
                searchButtonSelector: document.getElementById("unbxd_search_btn"),
                searchResultsSelector: document.getElementById("searchResultsWrapper"),
                siteKey: UnbxdSiteName,
                apiKey: UnbxdApiKey,
                allowedQueryParams: ["q","viewType","p","p-id"],
                searchMinimumValueCount: 10,
                products: {
                    productType: "CATEGORY",
                    el: document.getElementById("searchResultsWrapper"),
                    tagName: "ol",
                    htmlAttributes: {
                        class: "filterproducts products list items product-items"
                    },
                    productClick: function (product, e) {
                        window.location = product.productLink;
                    },
                    "attributesMap": {
                        "unxTitle": "title",
                        "unxImageUrl": "imageUrl",
                        "unxPrice": "price",
                        "unxStrikePrice": "originalPrice",
                        "unxId": "uniqueId",
                        "unxDescription": "description"
                    },
                    productAttributes: [
                        "title",
                        "uniqueId",
                        "price",
                        "sku",
                        "productUrl",
                        "productLink",
                        "imageUrl",
                        "description",
                        "availabilityText"
                    ],
                    "defaultImage": "https://www-staging.downies.com/static/version1639473673/frontend/Collectables/base/en_AU/images/white.png",
                    "template": function (product, idx, swatchUI, productViewType, products) {
                        try {
                            if (idx == 1) {
                                if (productViewType == "LIST") {
                                    products.el.classList.add("list", "products-list");
                                    products.el.classList.remove("grid", "products-grid");
                                } else {
                                    products.el.classList.add("grid", "products-grid");
                                    products.el.classList.remove("list", "products-list");
                                }
                            }
                            const {
                                unxTitle,
                                unxImageUrl,
                                uniqueId,
                                unxStrikePrice,
                                unxPrice,
                                unxDescription,
                            } = product;
                            const {
                                defaultImage
                            } = products;
                            let imgUrl = Array.isArray(unxImageUrl) ? unxImageUrl[0] : unxImageUrl;
                            if (!imgUrl) {
                                imgUrl = defaultImage;
                            }


                            let imagesUI = [`<a href="${product.productUrl}" class="product photo product-item-photo" tabindex="-1" unbxdParam_pid="${uniqueId}" unbxdParam_pRank="${idx}" unbxdAttr="product" data-item="product">`,
                                `<img class="photo image" src="${imgUrl}?optimize=high&bg-color=255,255,255&fit=bounds&height=479&width=479&canvas=479:479" width="479" height="479" alt="${unxTitle}" style="display: block;">`,
                                `</a>`].join('');

                            let productNameUI = [`<h2 class="product name product-item-name">`,
                                `<a class="product-item-link" href="${product.productUrl}" unbxdParam_pid="${uniqueId}" unbxdParam_pRank="${idx}" unbxdAttr="product" data-item="product">${unxTitle}</a></h2>`,
                                `<div class="sku-rating-wrap">`,
                                `<div class="sku">Product Code: <strong>${product.sku}</strong></div>`,
                                `</div>`].join('');
                            let descriptionUI = '';
                            if (productViewType == "LIST" && unxDescription) {
                                sanitizedDescription = jQuery(unxDescription).text().replaceAll('\n', '');
                                trimmedDescription = sanitizedDescription.length > 169 ? sanitizedDescription.substring(0, 169) + " ... " : sanitizedDescription;
                                moreLink = sanitizedDescription.length > 169 ? `<a href="${product.productUrl}" title="${unxTitle}" class="action more" unbxdParam_pid="${uniqueId}" unbxdParam_pRank="${idx}" unbxdAttr="product" data-item="product">More</a></div>` : `</div>`,
                                    descriptionUI = [`<div class="product description product-item-description">${trimmedDescription}`,
                                        moreLink
                                    ].join('');
                            }

                            let oldPrice = "";
                            if (unxStrikePrice && unxPrice && unxStrikePrice > unxPrice) {
                                formattedPrice = Number(parseFloat(unxStrikePrice).toFixed(2)).toLocaleString('en', {
                                    minimumFractionDigits: 2
                                });
                                oldPrice = [`<span class="old-price"><span class="price-container price-final_price tax weee">`,
                                    `<span class="price-label" avt-org-val-0="was">was</span>`,
                                    `<span id="old-price-${uniqueId}" data-price-amount="${unxStrikePrice}" data-price-type="oldPrice" class="price-wrapper "><span class="price">$${formattedPrice}</span></span>`,
                                    `</span></span>`
                                ].join("");
                            }

                            let price = "";
                            if (unxPrice) {
                                formattedPrice = Number(parseFloat(unxPrice).toFixed(2)).toLocaleString('en', {
                                    minimumFractionDigits: 2
                                });
                                let specialPriceLabel = "";
                                if (unxStrikePrice && unxPrice && unxStrikePrice < unxPrice) {
                                    priceLabel = `<span class="special-price"><span class="price-container price-final_price tax weee"><span class="price-label" avt-org-val-0="Special Price">Special Price</span>`;
                                } else {
                                    priceLabel = `<span><span class="price-container price-final_price tax weee">`;
                                }
                                price = [priceLabel,
                                    `<span id="special-price-${uniqueId}" data-price-amount="${unxPrice}" data-price-type="finalPrice" class="price-wrapper "><span class="price">$${formattedPrice}</span></span>`,
                                    `</span></span>`
                                ].join("");
                            }


                            wishlistPost = JSON.stringify({ "action": window.location.origin + "/wishlist/index/add/", "data": { "product": String(uniqueId), "uenc": btoa(window.location.href) } }).replaceAll('"', atob('JnF1b3Q7'));
                            addToList = `<a href="javascript://" class="action towishlist" title="Add to Wish List" aria-label="Add to Wish List" data-post="${wishlistPost}" data-action="add-to-wishlist" role="button"><span>Add to Wish List</span></a>`;
                            //compareProductPost = JSON.stringify({"action": window.location.origin+"/catalog/product_compare/add/","data":{"product" : String(uniqueId),"uenc":btoa(window.location.href)}}).replaceAll('"',atob('JnF1b3Q7'));
                            //addToCompareList=`<a href="javascript://" class="action tocompare" title="Add to Compare" aria-label="Add to Compare" data-post="${compareProductPost}" data-action="add-to-wishlist" role="button"><span>Add to Compare</span></a>`;



                            if (product.availabilityText && "true" == product.availabilityText) {
                                availabilityUI = '<div class="stock-lable available"><span>In stock</span></div>';
                            } else {
                                availabilityUI = '<div class="stock-lable unavailable"><span>Out of stock</span></div>';
                            }

                            var formKey = jQuery('input[name="form_key"]').val();

                            secondaryLinksUI = [`<div data-role="add-to-links" class="actions-secondary">`,
                                addToList,
                                //addToCompareList,
                                `</div>`].join('');


                            viewDetailsUI = [`<div class="actions-detail">`,
                                `<a class="view-detail" href="${product.productUrl}" unbxdParam_pid="${uniqueId}" unbxdParam_pRank="${idx}" unbxdAttr="product" data-item="product">View Detail</a>`,
                                `</div>`
                            ].join('');
                            primaryActionUI = '';
                            if (product.availabilityText && "false" == product.availabilityText) {
                                primaryActionUI = `<div class="actions-primary"><div class="stock unavailable"><span>Out of stock</span></div></div>`;
                            } else {
                                uenc = btoa(window.location.origin + "/checkout/cart/add/uenc/" + btoa(window.location.href) + "/product/" + uniqueId);

                                primaryActionUI = ['<div class="actions-primary"><form data-role="tocart-form" class="unbxd-product-to-cart" data-product-sku="' + uniqueId + '" action="' + window.location.origin + '/checkout/cart/add/product/' + uniqueId + '/" method="post">',
                                    '<input type="hidden" name="product" value="' + uniqueId + '">',
                                    '<input type="hidden" name="uenc" value="' + uenc + '">',
                                    '<input name="form_key" type="hidden" value="' + formKey + '">',
                                    `<button type="submit" title="Add to Cart" id="addtocart_${uniqueId}" unbxdattr="product"  unbxdparam_sku="${uniqueId}" unbxdparam_prank="${idx}" class="action tocart primary"><span>Add to Cart</span></button>`,
                                    `</div>`,
                                    '</form></div>'].join('');
                            }



                            return [`<li class="item product product-item" id="${uniqueId}" data-id="${uniqueId}" data-prank="${idx}" data-item="product">`,
                                `<div class="product-item-info" data-container="product-grid" style="z-index: 2000;">`,
                                imagesUI,
                                `<div class="product details product-item-details">`,
                                productNameUI,
                                descriptionUI,
                                `<div class="list-col-right  special_item">`,
                                `<div class="price-box price-final_price" data-role="priceBox" data-product-id="${uniqueId}" data-price-box="product-id-${uniqueId}">`,
                                price,
                                oldPrice,
                                `</div>`,
                                ` <div class="product-item-inner">`,
                                `<div class="product actions product-item-actions">`,
                                secondaryLinksUI,
                                availabilityUI,
                                viewDetailsUI,
                                primaryActionUI,
                                `</div>`,
                                `</div>`,
                                `</div>`,
                                `</div>`,
                                `</div></li>`
                            ].join('');
                        } catch (e) {
                            console.error("Error while fetching product" + product.uniqueId, e);
                            return '';
                        }

                    }
                },
                spellCheck: {
                    enabled: true,
                    el: document.getElementById("toolbar-amount"),
                    clonedEl: document.querySelectorAll('.toolbar-amount-cloned'),
                    template: function (query, suggestion, pages) {
                        const {
                            start,
                            productsLn,
                            numberOfProducts
                        } = pages;
                        const {
                            selectorClass
                        } = this.options.spellCheck;
                        if (numberOfProducts > 0) {
                            countUi = `Items <span class="toolbar-number">${start + 1}</span>-<span class="toolbar-number">${productsLn + start}</span> of <span class="toolbar-number">${numberOfProducts}</span>`;
                        }
                        jQuery('#unbxd-spell-check').empty();
                        if (suggestion) {
                            jQuery('#unbxd-spell-check').append(`<dt class="title">Did you mean</dt><dd class="item"> Your search "<strong>${suggestion}</strong>" did not match any products.Search Results for "<strong>${query}</strong>". </dd>`);
                        }

                        return countUi;
                    }
                },
                noResults: {
                    //noResultEl: document.getElementById("noResultWrapper"),
                    el: document.getElementById("noResultWrapper"),
                    template: function (query) { return `<div class="UNX-no-results" style="color:black;font-size: 32px;margin-left: -25%;"> No Results found ${query} </div>` }
                },
                facet: {
                    "facetsEl": document.getElementById("facetsWrapper"),
                    "selectedFacetsEl": document.getElementById("selectedFacetWrapper"),
                    "selectedFacetTemplate": function selectedFacetUI(selections, facet, selectedFacetsConfig) {
                        const {
                            clearAllText,
                            clearFacetsSelectorClass
                        } = facet;
                        const selectedFClass = (this.selectedFacetClass) ? this.selectedFacetClass : selectedFacetsConfig.selectedFacetClass;
                        document.getElementById('selectedFacetWrapper').style.display="none";
                        if (selections.length > 0) {
                            document.getElementById('selectedFacetWrapper').style.display="block";
                            return [`<div class="UNX-facets-selections">`,
                                `<h5 class="block-subtitle filter-current-subtitle">NOW SHOPPING BY</h5>`,
                                `<div class="UNX-selected-facets-inner">${selections}</div>`,
                                `<button class="${clearFacetsSelectorClass} ${selectedFClass}" data-facet-action="clearAllFacets">${clearAllText}</button>`,
                                `</div>`].join('');
                        } else {
                            return ``;
                        }
                    },
                    "selectedFacetItemTemplate": function selectedFacetItemTemplateUI(selectedFacet, selectedFacetItem, facetConfig, selectedFacetsConfig) {
                        const {
                            facetName,
                            facetType
                        } = selectedFacet;
                        const {
                            name,
                            count,
                            dataId
                        } = selectedFacetItem;
                        const {
                            facetClass,
                            selectedFacetClass,
                            removeFacetsSelectorClass
                        } = this.options.facet;
                        const {
                            UNX_uFilter
                        } = this.testIds;
                        let action = "deleteSelectedFacetValue"
                        let displayName = "";
                        if (facetType === "range") {
                            action = "deleteSelectedRange"
                            displayName = "Price";
                        } else {
                            if (this.state.responseObj.facets.text) {
                                let selectedFacetObj = this.state.responseObj.facets.text.list.filter(function (facetTemp) {
                                    return facetTemp.facetName == facetName;
                                });
                                if (selectedFacetObj && selectedFacetObj.length > 0) {
                                    displayName = selectedFacetObj[0].displayName;
                                }
                            }
                        }
                        const css = ` ${facetClass} ${selectedFacetClass} `;
                        return [`<div class="UNX-selected-facets-wrap">`,
                            `<button class="UNX-delete-facet ${removeFacetsSelectorClass} ${css}" data-id="${dataId}" data-facet-action="${action}" data-facet-name="${facetName}"></button>`,
                            `<button data-test-id="${UNX_uFilter}" class="UNX-selected-facet-btn UNX-change-facet ${css}" data-facet-name="${facetName}" data-facet-action="${action}" data-id="${dataId}">`,
                            `<span class="UNX-facet-name">${displayName}:</span> <span class="UNX-facet-value">${decodeURIComponent(name)}</span>`,
                            `</button></div>`,
                        ].join('');
                    },
                    defaultOpen: "FIRSTOFEACH",
                    enableViewMore: true,
                    viewMoreText: ["Show more", "Show less"],
                    viewMoreLimit: 10,
                    onFacetLoad: function (facets) {
                        const self = this;
                        const { facet } = this.options;
                        const { rangeWidgetConfig } = facet;
                        facets.forEach((facetItem) => {
                            const { facetType, facetName, gap } = facetItem;
                            const { prefix } = rangeWidgetConfig;

                            if (facetType === "range") {
                                require(['nouislider'],function(noUiSlider){
                                    const rangeId = `${facetName}_slider`;
                                    const sliderElem = document.getElementById(rangeId);
                                    let { end, gap, max, min, start } = facetItem;
                                    const selectedValues = sliderElem.dataset;
                                    if (selectedValues) {
                                        (start = Number(selectedValues.x)),
                                            (end = Number(selectedValues.y));
                                    }
                                    self[rangeId] = noUiSlider.create(sliderElem, {
                                        start: [start, end],
                                        tooltips: [
                                            {
                                                to: function (value) {
                                                    return `${prefix} ${Math.round(value)}`;
                                                }
                                            },
                                            {
                                                to: function (value) {
                                                    return `${prefix} ${Math.round(value)}`;
                                                }
                                            }
                                        ],
                                        connect: true,
                                        range: {
                                            min: min,
                                            max: max
                                        },
                                        format: {
                                            to: function (value) {
                                                return Math.round(value);
                                            },
                                            from: function (value) {
                                                return Math.round(value);
                                            }
                                        },
                                        padding: 0,
                                        margin: 0
                                    });
                                    self[rangeId].on("set", function (data) {
                                        const newData = {
                                            start: data[0],
                                            end: data[1],
                                            facetName,
                                            gap
                                        };
                                        self.setRangeSlider(newData);
                                    });
                                });

                            }
                        });
                    },
                    rangeTemplate: function (range, selectedRange, facet) {
                        const { facetName, start, end } = range;
                        let min = start;
                        let max = end;
                        if (selectedRange.length > 0) {
                            const sel = selectedRange[0].replace(/[^\w\s]/gi, "").split(" TO ");
                            min = sel[0];
                            max = sel[1];
                        }
                        const rangId = `${facetName}_slider`;
                        return [
                            `<div id="${facetName}"  data-id="${facetName}" class=" UNX-range-slider-wrap">`,
                            `<div class="UNX-value-container UNX-range-value-block" ></div>`,
                            `<div id="${rangId}" data-x="${min}" data-y="${max}" class="UNX-range-slider-wrapper"></div>`,
                            `</div>`,
                            `<div>`,
                            `</div>`
                        ].join("");
                    }
                },
                sanitizedQueryParam: true,
                friendlyUrlComponents: {
                    sort: true,
                    sortLabel: 'sort',
                    size: true,
                    sizeLabel: 'count',
                    page: true,
                    pageLabel: 'page',
                    facet: true

                },
                facetConfig: {
                    dynamicRangeFacets: ["price"],
                    urlConfig: {
                        facetsWithFriendlyUrl: ["brand_uFilter", "scale_uFilter", "quality_uFilter", "denomination_uFilter", "metal_uFilter", "countryofissue_uFilter", "grade_uFilter","diameter_uFilter","metalpurity_uFilter", "price"], // If empty indicates that all facets needs to be friendly  in tandem with friendlyUrl
                        facetsOrderInUrl: ["brand_uFilter", "scale_uFilter", "quality_uFilter", "denomination_uFilter", "metal_uFilter", "countryofissue_uFilter", "grade_uFilter","diameter_uFilter","metalpurity_uFilter", "price"],
                        facetPartIndex: 99,
                        facetDisplayNameMap: {
                            "quality": "quality_uFilter",
                            "grade": "grade_uFilter",
                            "scale": "scale_uFilter",
                            "brand": "brand_uFilter",
                            "front_color_user": "lensColour_uFilter",
                            "denomination": "denomination_uFilter",
                            "metal": "metal_uFilter",
                            "countryofissue": "countryofissue_uFilter",
                            "diameter" :"diameter_uFilter",
                            "metalpurity":"metalpurity_uFilter",
                            "price":"price"

                        }
                    }
                },
                pagination: {
                    el: document.querySelectorAll(".unbxd-pagination"),
                    type: 'FIXED_PAGINATION',
                    pageLimit: 10
                },
                breadcrumb: {
                    el: document.getElementById("breadcrumpContainer"),
                    enabled: false
                },
                pagesize: {
                    pageSize: 9,
                    options: [9, 15, 24, 50],
                    el: document.getElementById("unbxd-pagesize"),
                    clonedEl: null,
                    pageSizeClass: "limiter-options"
                },

                sort: {
                    el: document.getElementById("unbxd-sort"),
                    clonedEl: null,
                    sortClass: "sorter-options",
                    template: function (selectedSort, sortConfig) {
                        let optionsUI = "";
                        const {
                            options,
                            sortClass,
                            selectedSortClass
                        } = sortConfig;
                        const {
                            UNX_unbxdSorter
                        } = this.testIds;
                        options.forEach((item) => {
                            const {
                                value,
                                text
                            } = item;
                            if(item.display){
                                if (value.split(" ")[0] == selectedSort.split(" ")[0]) {
                                    optionsUI += `<option value="${value}" class="${selectedSortClass}" selected>${text}</option>`;
                                } else {
                                    optionsUI += `<option value="${value}">${text}</option>`;
                                }
                            }
                        })
                        if (selectedSort && selectedSort.indexOf("desc") > -1) {
                            sorterUI = `<a title="Set Ascending Direction"  class="action sorter-action sort-desc js-sort-changer"  data-value="asc"><span>Set Ascending Direction</span></a>`;
                        } else {
                            sorterUI = `<a title="Set Descending Direction"  class="action sorter-action sort-asc js-sort-changer" data-value="desc"><span>Set Descending Direction</span></a>`;
                        }
                        return [`<div class="UNX-sort-block">`,
                            `<span class="UNX-sort-header">Sort By</span>`,
                            `<label class="UNX-hidden" for="unxSortSelect">Sort By</label>`,
                            `<select data-test-id="${UNX_unbxdSorter}" name="unxSortSelect" data-action="changeSort" id="unxSortSelect" class="${sortClass}">`,
                            `<option value="">Relevancy</option>`,
                            optionsUI,
                            `</select>`,
                            sorterUI,
                            `</div>`].join('')
                    },
                    options: [
                        {
                            value: "price desc",
                            text: "Price",
                            display: true,
                            friendlyUrlText:"price-high-low-desc"

                        },
                        {
                            value: "price asc",
                            text: "Price",
                            display: false,
                            friendlyUrlText:"price-low-high-asc"

                        },
                        {
                            value: "countryofissue desc",
                            text: "Country of Issue",
                            display: true,
                            friendlyUrlText:"country-of-issue-desc"
                        },
                        {
                            value: "countryofissue asc",
                            text: "Country of Issue",
                            display: false,
                            friendlyUrlText:"country-of-issue-asc"
                        },
                        {
                            value: "diameter desc",
                            text: "Diameter (mm)",
                            display: true,
                            friendlyUrlText:"diameter-mm-desc"
                        },
                        {
                            value: "diameter asc",
                            text: "Diameter (mm)",
                            display: false,
                            friendlyUrlText:"diameter-mm-asc"
                        }
                    ]
                },
                loader: {
                    el: document.getElementById("loaderEl")
                },
                productView: {
                    clonedEl: null,
                    el: document.getElementById("unbxd-product-view"),
                    selectedViewTypeClass: "active",
                    viewTypeClass: "modes-mode",
                    template: function (selectedViewType, productViewType) {
                        const isDisabled = (this.getSearchResults()) ? false : true;
                        const {
                            selectedViewTypeClass,
                            viewTypeClass
                        } = productViewType;
                        let listBtnCss = "";
                        let gridBtnCss = "";
                        if (selectedViewType === 'LIST') {
                            listBtnCss = `${selectedViewTypeClass}`
                        }
                        if (selectedViewType === 'GRID') {
                            gridBtnCss = `${selectedViewTypeClass}`
                        }
                        let viewAsLabel = `<strong class="modes-label" id="modes-label">View as</strong>`;
                        let listBtn = `<a class="modes-mode ${listBtnCss} mode-list" title="List" id="mode-list" aria-labelledby="modes-label mode-list" data-view-action="LIST"><span data-view-action="LIST">List</span></a>`
                        let gridBtn = `<a class="modes-mode ${gridBtnCss} mode-grid" title="Grid"  id="mode-grid" aria-labelledby="modes-label mode-grid" data-view-action="GRID"><span data-view-action="GRID">GRID</span></a>`
                        return `${viewAsLabel}${listBtn} ${gridBtn}`
                    }
                },
                banner: {
                    el: document.getElementById("bannerContainer"),
                    count: 1
                },
                "onEvent": function (state, type) {

                    if (!window.UnbxdEventBinding) {
                        jQuery(document).on('click','.UNX-facet-trigger',function(e){
                            const {
                                facet
                            } = e.target.dataset;
                            if(facet && facet == "open"){
                                jQuery('.page-wrapper .header').hide();
                            }else if(facet && facet == "close"){
                                jQuery('.page-wrapper .header').show();
                            }

                        });
                        jQuery(document).on('click', '.js-sort-changer', function (e) {
                            var $ele = jQuery(this);
                            $direction = $ele.data('value');
                            $selectedSort = unbxdSearch.state.selectedSort;
                            if ($selectedSort) {
                                unbxdSearch.applySort($selectedSort.split(' ')[0] + " " + $direction);
                            } else {
                                unbxdSearch.applySort('score ' + $direction);
                            }
                        });
                        jQuery(document).on('click','.filter-current-subtitle',function(e){
                            jQuery('#selectedFacetWrapper').toggleClass('active');
                        });
                        window.UnbxdEventBinding = true;
                    }

                    if (type == "BEFORE_API_CALL") {
                        jQuery('.unbxd-toggle-onload').hide();
                    }

                    if (type == "AFTER_RENDER") {

                        unbxdSearch.bindClonedElements();
                        jQuery('.toolbar.toolbar-products').show();
                        jQuery('#layered-filter-block').show();
                        if(unbxdSearch.viewState.lastAction){
                            jQuery('html, body').animate({
                                scrollTop: jQuery(".page-main").offset().top
                            }, 300);
                        }
                        jQuery('.unbxd-toggle-onload').show();
                        // require(['jquery', 'lazyload'], function ($) {
                        //     var lzimages = $('.photo.image').lazyload({
                        //         placeholder: '/static/version1639473673/frontend/Collectables/base/en_AU/images/white.png'
                        //     });
                        //
                        // });
                    }
                    if (type == "AFTER_RENDER") {
                        require(['jquery', 'catalogAddToCart', 'wishlist', 'addToWishlist', 'wishlistSearch'], function (jQuery) {
                            var currentF = jQuery('form[data-role="tocart-form"]');
                            currentF.attr('data-mage-init', JSON.stringify({ 'catalogAddToCart': {} }));
                            var mageInit = currentF.attr('data-mage-init');
                            if (typeof mageInit !== 'undefined') {
                                jQuery(currentF).catalogAddToCart();
                                currentF.removeAttr('data-mage-init');
                            }
                        });
                    }

                    if (type == "BEFORE_NO_RESULTS_RENDER") {
                        jQuery('.toolbar.toolbar-products').hide();
                    }

                },
                swatches: {
                    enabled: false,
                    attributesMap: {
                        swatchList: "color",
                        swatchImgs: "unbxd_color_mapping",
                        swatchColors: "color"
                    }
                },
                hashMode: false,
                updateUrls: true,
                variants: {
                    enabled: true,
                    count: 1,
                    groupBy: "",
                    attributes: [],
                    mapping: {
                        image_url: "v_image_url"
                    }
                },
                unbxdAnalytics: true,
            };
        });
    }
)