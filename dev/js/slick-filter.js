(function( $ ) {
    $.fn.slickFilterable = function( options ) {

        /**
         * A plugin to create a slick we can filter.
         *
         * If you are not using Rows you can use slickFilter
         * (check documentation) otherwise we can provide a valid filter.
         *
         * options {
         *      slideSelector    string     jQuery selector to get slides. Imetiate children by default.
         *      filterName       string     We will search for data-{filterName} clickable elements.
         *      slick            object     The slick settings. Check Slick doc.
         *      beforeFilter     function   A fuction called before filter slider. Receives the trigger element
         *                                  as this and 3 params: category (string), slider and slides (jQuery objects).
         *      filter           mix        A valid parameter to jQuery filter() function. If it's a functio we will wrap
         *                                  it and it receives the trigger element as this and 3 params: category (string),
         *                                  slider (jQuery object) and a copy of settings (extended).
         * }
         */
        var settings = $.extend({
            slideSelector: '> *',
            filterName: 'filter-slick',
            slick: {},
            beforeFilter: function() {},
            filter: function( element, category, slider, settings ) { return true; },
        }, options );

        return this.each(function() {
            var slider = $(this),
                slides = slider.find( settings.slideSelector ),
                slickObj;

            /**
             * Create Slick
             *
             * TIP: you should you 'slidesPerRow' instead 'slidesToShow' in grid mode (with rows)
             * to avoid slick break layout when there are less slides than on "page".
             */
            slickObj = slider.slick( settings.slick );

            // Handle Filter Click
            //$('[data-' + settings.filterName + ']').on('click', function(event) {
            $('#partners').selectric().on('change', function(event) {
                event.preventDefault();

                var category = $(this).val(),
                    newSlides = $.extend(true, {}, slides),
                    newSlickOptions;

                if ( ! category ) return;

                // Before Filter Slides
                if ( typeof settings.beforeFilter == 'function' ) {
                    settings.beforeFilter.call(this, category, slider, slides);
                }

                // Destroy and empty
                slider.slick('unslick');

                // Recreate All Slides
                if ( category === 'all' ) {
                    slider.find( settings.slideSelector ).remove();
                    slider.append( newSlides );
                    slider.slick( settings.slick );

                    return;
                }

                /**
                 * Filter Slides
                 *
                 * If settings.filter is a function we pass the category, slider and a copy of settings
                 * expecting a true or false return to pass it to jQuery.filter();
                 *
                 * If not, we just pass it directly.
                 */
                if ( typeof settings.filter !== 'function' ) {
                    newSlides = newSlides.filter( settings.filter );
                } else {
                    newSlides = newSlides.filter( function() {
                        return settings.filter.call( this, category, slider, $.extend( true, {}, settings ) );
                    } );
                }

                slider.find( settings.slideSelector ).remove();
                slider.append( newSlides );
                slider.slick( settings.slick );
            });
        });
    };
}(jQuery));