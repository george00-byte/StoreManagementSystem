$(function () {
    let headerElem = $(`header`);
    let logo = $(`#logo`);
    let navMenu = $(`#nav-menu`);
    let navToggle = $(`#nav-toggle`);




    $('#property-search').on('click',() => {
        const contactDivPosition = document.getElementById('properties').offsetTop;
        window.scroll({
            top: contactDivPosition + 30,
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
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 480,
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


    $('.testimonials-slider').slick(
        {
            infinite: true,
            autoplay: true,
            slidesToScroll: 1,
            slidesToShow: 1,
            prevArrow: '<a href="#" class="slick-arrow slick-prev"></a>',
            nextArrow: '<a href="#" class="slick-arrow slick-next"></a>'

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


ClassicEditor
    .create(document.querySelector('#body'), {
        toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote'],
        heading: {
            options: [
                { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' }
            ]
        }
    })
    .catch(error => {
        console.log(error);
    });
