
$(function () {

    $('html').toggleClass('is-ios', /(iphone|ipod|ipad)/.test(navigator.userAgent.toLowerCase()));


    //Header fixed (escritorio)
    var pixelsFromTheTop = 45;
    $(window).bind('scroll',function () {
        var scrollTop = $(window).scrollTop();
        $('body').toggleClass('nav-fixed', scrollTop > pixelsFromTheTop)
    });


    //Menú toggle (mobile)
    $('.header-nav .logo-top .menu-toggle').on('click', function(e){
        e.preventDefault();
        $(this).closest('.header-nav').toggleClass('mobile-open')
    });


    //Menú idiomas
    $('.header-nav .nav-top .language > a').on('click', function(e){
        e.preventDefault();
        $(this).next().toggleClass('hidden')
    });


    //HOME - Key benefits
    if( $('.key-benefits').length ){

        $('.key-benefits').on('click', '.nav a', function(e){
            e.preventDefault();
            var me = $(this);
            me.parent().addClass('selected').siblings().removeClass('selected');

            var id = me.attr('href');
            $('.key-benefits .content > div').hide();
            $('.key-benefits .content > div').filter(id).show();
        });

        $('.key-benefits .content > div').hide();
        $('.key-benefits .nav a').eq(0).trigger('click');

    }


    //FAQS
    if( $('.faqs').length ){

        $('.faqs').on('click', 'h4', function(e){
            var me = $(this);
            if(me.hasClass('open')){
                me.removeClass('open').next().slideUp(150);
            }else{
                me.addClass('open').next().slideDown(150);
            }
        }).find('> div').hide();

    }


    //NEWS - load more
    if( $('.news-list').length ){

        var allItems  = $('.news-list .news-item'),
            numItems  = allItems.length,
            maxItems  = $('.news-list').data('max-items'),
            moreItems = $('.news-list').data('more-items');

        if(numItems > maxItems){
            allItems.filter(':gt('+(maxItems-1)+')').parent().hide();
            $('.news-list .load-more').removeClass('hidden').on('click', 'span', function(){
                var n = $('.news-list .news-item').filter(':hidden:lt('+moreItems+')').parent().slideDown(150);

                if(allItems.filter(':hidden').length == 0){
                    $('.news-list .load-more').addClass('hidden');
                }
            });
        }

    }


    //Habilitar validación formulario
    if( $('form[data-validate="true"]').length ){
        $('form[data-validate="true"]').enableValidation();
    }


    //Formularios subscripción
    $('form.bulletin-form').on('submit', function(e){
        e.preventDefault();
        var form = $(this);
        var errors = $('.errors', form);
        errors.html('');

        var elem = $('input[name="email"]', form);
        var is_form_ok = (/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,6})+$/.test(elem.val()));

        if(!is_form_ok){
            errors.html(elem.data('error'));
        }else{
            var data = {
                action: 'send_mailchimp',
                email: elem.val(),
                lang : $('input[name="lang"]', form).val()
            };
            $.ajax({
                url: form.attr('action'),
                method: form.attr('method'),
                dataType: 'json',
                data: data,
                success: function(data){
                    if(data.error == 0){
                        elem.val('');
                        errors.html(form.data('msg-success'));
                    }else if(data.error == 1){
                        errors.html(form.data('msg-error'));
                    }else if(data.error == 2){
                        errors.html(form.data('msg-error-email'));
                    }
                }
            });
        }
    });


    //HOME - Youtube full viewport
    $('a.youtube-fullview').on('click', function(e){
        e.preventDefault();

        var id        = getYoutubeID( $(this).attr('href') ),
            container = $('<div class="fullview">'),
            iframe    = $('<iframe frameborder="0">').attr('src', 'https://www.youtube.com/embed/'+id+'?autoplay=1&rel=0&fs=0&showinfo=0'),
            closeBtn  = $('<span class="btn-close">').text('Close').on('click', function(e){ $('.fullview').remove(); });

        container.append(closeBtn).append(iframe).prependTo('body');
    });

});



(function($) {

    var form, errors, is_form_ok;

    $.fn.enableValidation = function() {
        if(this.prop("tagName") != 'FORM'){
            if(console && console.log) console.log("Element is not a FORM.");
            return false;
        }

        form = this;
        form.attr('novalidate', 'novalidate').on('submit', onSubmit);
        errors = $('div.errors', form);
    }

    function onSubmit(e){
        is_form_ok = true;
        errors.html('');

        $('*[data-validation]', form).removeClass('error').each(validateField);

        var isContactForm = form.hasClass('form-type-contact');

        if(isContactForm){
            e.preventDefault();
            if(is_form_ok) {
                sendContactAjax();
            }
        }

        if(!is_form_ok){
            e.preventDefault();
        }
    }

    function validateField(index, node){
        var elem  = $(node);
        var is_ok = isValidField(elem, elem.data('validation'));

        if(!is_ok){
            is_form_ok = false;
            elem.addClass('error');
            var errorMsg = $('<p>').text( elem.data('error-msg') )
            errors.append(errorMsg)
        }
    }

    function isValidField(elem, rule){
        if('not-empty' == rule){
            return elem.val() != '';
        }else if('email' == rule){
            return /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,6})+$/.test(elem.val());
        }else if('repeat' == rule){
            return elem.val() == $(elem.data('repeat-field')).val();
        }else if('telephone' == rule){
            return elem.val() != '';
        }else if('select' == rule){
            return elem.val() != '';
        }else if('checkbox' == rule){
            return elem.is(':checked');
        }else if('password' == rule){
            return elem.val().length >= 12;
        }
        return true;
    }

    function sendContactAjax(){
        $.ajax({
            url: form.attr('action'),
            method: form.attr('method'),
            dataType: 'json',
            data: form.serialize(),
            success: function(data){
                if(data.error == 0){
                    form.get(0).reset();
                    errors.html(form.data('msg-success'));
                }else{
                    errors.html(form.data('msg-error'));
                }
            }
        });
    }

}( jQuery ));


function getYoutubeID(url){
    var ID = '';
    url = url.replace(/(>|<)/gi,'').split(/(vi\/|v=|\/v\/|youtu\.be\/|\/embed\/)/);
    if(url[2] !== undefined) {
        ID = url[2].split(/[^0-9a-z_\-]/i);
        ID = ID[0];
    }
    else {
        ID = url;
    }
    return ID;
}
