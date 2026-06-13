$(document).ready(function () {

    // Desktop dropdown: expand/collapse grandchildren — toggle arrow only
    $(document).on('click', '.nav-sub-toggle', function (e) {
        e.preventDefault();
        e.stopPropagation(); // prevent Bootstrap closing the dropdown
        var $item = $(this).closest('.nav-sub-item');
        var isOpen = $item.hasClass('open');

        // Collapse all siblings first (accordion)
        $item.siblings('.nav-sub-item.open')
             .removeClass('open')
             .find('.nav-grandchild-list').slideUp(200);

        // Toggle current
        if (isOpen) {
            $item.removeClass('open').find('.nav-grandchild-list').slideUp(200);
        } else {
            $item.addClass('open').find('.nav-grandchild-list').slideDown(200);
        }
    });

    // Prevent dropdown from closing when clicking inside it
    $(document).on('click', '.dropdown-menu', function (e) {
        e.stopPropagation();
    });

    // Mobile menu accordion
    $(document).on('click', '.mobile-side-menu .mmenu-toggle', function (e) {
        e.stopPropagation();
        var $li = $(this).closest('li');
        var $ul = $li.children('ul');
        if ($ul.length) {
            // Accordion: close siblings
            $li.siblings('li.open').removeClass('open').children('ul').slideUp(300);
            $ul.slideToggle(300, function () { $li.toggleClass('open'); });
        }
    });

});
