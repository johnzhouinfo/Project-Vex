/**
 *   Vex-Page Start
 */
$('.drop').load(function () {

    var style = $("<style data-reserved-styletag></style>").html(GetInsertionCSS);
    var frameWindow = $(this).prop('contentWindow');
    var prev;

    //insert the style for marker and
    $(frameWindow.document.head).append(style);
    //define marker tag
    $contextMarker = $("<div data-dragcontext-marker><span data-dragcontext-marker-text></span></div>");
    //add mouse listener
    frameWindow.document.body.onmouseover = handler;

    /**
     * This method will detect the mouse location, it will mark the content (e.g div, form, etc.) when mouse
     * are located in the top of a content, remove the mark when mouse left
     * @param event
     */
    function handler(event) {

        if (event.target === document.body ||
            (prev && prev === event.target)) {
            return;
        }
        if (prev) {
            prev = undefined;
        }
        if (event.target) {
            prev = event.target;
            var rect = prev.getBoundingClientRect();
            $contextMarker.css({
                height: (rect.height + 4) + "px",
                width: (rect.width + 4) + "px",
                top: (rect.top + $(frameWindow).scrollTop() - 2) + "px",
                left: (rect.left + $(frameWindow).scrollLeft() - 2) + "px"
            });
            if (rect.top + $(".drop").contents().find("body").scrollTop() < 24)
                $contextMarker.find("[data-dragcontext-marker-text]").css('top', '0px');
            //show the tag name in marker
            var name = prev.tagName;
            $contextMarker.find('[data-dragcontext-marker-text]').html(name);
            if ($(".drop").contents().find("body [data-sh-parent-marker]").length != 0)
                $(".drop").contents().find("body [data-sh-parent-marker]").first().before($contextMarker);
            else
                $(".drop").contents().find("body").append($contextMarker);
        }
    }

});

/**
 * A pre-code style insert into the iframe page
 * @returns CSS style code
 * @constructor
 */
GetInsertionCSS = function () {
    var styles = "" +
        ".reserved-drop-marker{width:100%;height:2px;background:#00a8ff;position:absolute}.reserved-drop-marker::after,.reserved-drop-marker::before{content:'';background:#00a8ff;height:7px;width:7px;position:absolute;border-radius:50%;top:-2px}.reserved-drop-marker::before{left:0}.reserved-drop-marker::after{right:0}";
    styles += "[data-dragcontext-marker],[data-sh-parent-marker]{outline:#19cd9d solid 2px;text-align:center;position:absolute;z-index:123456781;pointer-events:none;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif}[data-dragcontext-marker] [data-dragcontext-marker-text],[data-sh-parent-marker] [data-sh-parent-marker-text]{background:#19cd9d;color:#fff;padding:2px 10px;display:inline-block;font-size:14px;position:relative;top:-24px;min-width:121px;font-weight:700;pointer-events:none;z-index:123456782}[data-dragcontext-marker].invalid{outline:#dc044f solid 2px}[data-dragcontext-marker].invalid [data-dragcontext-marker-text]{background:#dc044f}[data-dragcontext-marker=body]{outline-offset:-2px}[data-dragcontext-marker=body] [data-dragcontext-marker-text]{top:0;position:fixed}";
    styles += '.drop-marker{pointer-events:none;}.drop-marker.horizontal{background:#00adff;position:absolute;height:2px;list-style:none;visibility:visible!important;box-shadow:0 1px 2px rgba(255,255,255,.4),0 -1px 2px rgba(255,255,255,.4);z-index:123456789;text-align:center}.drop-marker.horizontal.topside{margin-top:0}.drop-marker.horizontal.bottomside{margin-top:2px}.drop-marker.horizontal:before{content:"";width:8px;height:8px;background:#00adff;border-radius:8px;margin-top:-3px;float:left;box-shadow:0 1px 2px rgba(255,255,255,.4),0 -1px 2px rgba(255,255,255,.4)}.drop-marker.horizontal:after{content:"";width:8px;height:8px;background:#00adff;border-radius:8px;margin-top:-3px;float:right;box-shadow:0 1px 2px rgba(255,255,255,.4),0 -1px 2px rgba(255,255,255,.4)}.drop-marker.vertical{height:50px;list-style:none;border:1px solid #00ADFF;position:absolute;margin-left:3px;display:inline;box-shadow:1px 0 2px rgba(255,255,255,.4),-1px 0 2px rgba(255,255,255,.4)}.drop-marker.vertical.leftside{margin-left:0}.drop-marker.vertical.rightside{margin-left:3px}.drop-marker.vertical:before{content:"";width:8px;height:8px;background:#00adff;border-radius:8px;margin-top:-4px;top:0;position:absolute;margin-left:-4px;box-shadow:1px 0 2px rgba(255,255,255,.4),-1px 0 2px rgba(255,255,255,.4)}.drop-marker.vertical:after{content:"";width:8px;height:8px;background:#00adff;border-radius:8px;margin-left:-4px;bottom:-4px;position:absolute;box-shadow:1px 0 2px rgba(255,255,255,.4),-1px 0 2px rgba(255,255,255,.4)}';
    return styles;

};

/*
    Vex-Page END
 */