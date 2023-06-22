$(function () {
    let headerElem = $(`header`);
    let logo = $(`#logo`);
    let navMenu = $(`#nav-menu`);
    let navToggle = $(`#nav-toggle`);


   

    $('.slick-slide').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        centerMode: true,
        autoplay: true,
        variableWidth: true,
        infinite: true,
        prevArrow: $(`.prev`),
        nextArrow: $(`.next`)
    });



    $('#ask-a-question').on('click', () => {
        const propetytDivPosition = document.getElementById('contact').offsetTop;
        window.scroll({
            top: propetytDivPosition + 30,
            left: 0,
            behavior: 'smooth'
        });
    });


  

    $('#properties-slider').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
        nextArrow: $(`.slick-prev`),
        prevArrow: $(`.slick-next`),
       


        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true,
                    dots: true
                }
            },
            {
                breakpoint: 760,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 560,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
        ]
    });

    navToggle.on(`click`, () => {
        navMenu.css('right', '0');
    });

    $(`#close-flyout`).on(`click`, () => {
        navMenu.css('right', '-100%');
    });



    $(document).scroll(() => {
        let scrollTop = $(document).scrollTop();

        if (scrollTop > 0) {
            navMenu.addClass('ls-sticky');
            logo.css('color', '#000');
            headerElem.css('background', '#fff');
            navToggle.css('border-color', '#000');
            navToggle.find('.strip').css('background-color', '#000');
        } else {
            navMenu.removeClass('ls-sticky');
            logo.css('color', '#fff');
            headerElem.css('background', 'transparent');
            navToggle.css('border-color', '#fff');
            navToggle.find('.strip').css('background-color', '#fff');
        }

        headerElem.css(scrollTop >= 200 ? { 'padding': '0.5rem', 'box-shadow': '0 -4px 10px 1px #999' } : { 'padding': '1rem 0', 'box-shadow': 'none' });
    });

    $(document).trigger('scroll');


});
