/**
 * Created by DynamicAction on 4/30/2018.
 */
navigator.UserBrowser = (function(){
    var ua= navigator.userAgent, tem,
        M= ua.match(/(opera|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i) || [];
    if(/trident/i.test(M[1])){
        tem=  /\brv[ :]+(\d+)/g.exec(ua) || [];
        return 'IE '+(tem[1] || '');
    }
    if(M[1]=== 'Chrome'){
        tem= ua.match(/\b(OPR|Edge)\/(\d+)/);
        if(tem!= null) return tem.slice(1).join(' ').replace('OPR', 'Opera');
    }
    M= M[2]? [M[1], M[2]]: [navigator.appName, navigator.appVersion, '-?'];
    if((tem= ua.match(/version\/(\d+)/i))!= null) M.splice(1, 1, tem[1]);
    return M.join(' ');
})();
var userBrowserAgent = navigator.UserBrowser;
var main_global;
jQuery(document).ready(function($){
    $('html').addClass(userBrowserAgent);

    main_global = {

        init: function(){
            this.selectCountry();
        },

        ajaxLoader: function(ele){
            var loader = '<span class="vc_icon_element-icon fa fa-refresh load-redirection ajax-loading"></span>';
            $(ele).prepend(loader);
        },
        selectCountry: function(){
            $('.select-country').val('NZ');
            $('.select-country').find('button img').attr('src', '/wp-content/uploads/2018/09/NZ_Flag-2.png');
            $('.select-country').find('button .sel-desc').text('NZ');
            $('.select-country').find('button').attr('title', 'NZ');

            $('.select-country').change(function(){
                var country_val = $(this).val();
                main_global.ajaxLoader('.bootstrap-select.select-country');
                var country_link;
                $('.bootstrap-select.select-country').find('button').attr('disabled', true);
                $('.bootstrap-select.select-country').find('button').addClass('btn-disabled');
                switch(country_val){
                    case 'AU':
                        location.href = 'https://empassion.com.au';
                        break;
                    case 'USA':
                        location.href = 'https://empassionnatural.com';
                        break;
                    default:
                        break;
                }
                //console.log(country_val);

            });
        },


    }

    main_global.init();


});