/**
 *                                                      Vex-Page Start
 *   -------------------------------------------------------------------------------------------------------------------
 */
$('.drop').load(function () {
    $("#drag-content").remove();
    $('#select-box').css("display", "none");
    var style = $("<style data-reserved-styletag></style>").html(GetInsertionCSS);
    var frameWindow = $(this).prop('contentWindow');
    var prev;

    // Insert the style for marker and
    $(frameWindow.document.head).append(style);
    // Define marker tag
    $contextMarker = $("<div data-dragcontext-marker><span data-dragcontext-marker-text></span></div>");
    // Add draggable element into the select-box
    $('#select-actions').prepend('<a id="drag-content" draggable="true" title="Drag" data-insert-html=" "><i class="fa fa-arrows"></i></a>');
    // Add mouse listener
    $(frameWindow.document).contents().on("mouseover", handler);

    // Once click the element in the frame, show the highlight the element, show the control panel
    $(frameWindow.document).contents().on("click", function (event) {
        event.preventDefault();
        //if the current element is editable, click in the element won't show the select-box
        if ($(event.target).attr("contenteditable"))
            return;
        selectTarget = event.target;
        // console.log("Inner click");

        // Show the select-box
        // Prevent user move element before/after body, html tags
        if (selectTarget.tagName.toLocaleLowerCase() !== 'html') {
            var rect = selectTarget.getBoundingClientRect();
            updateTagNameDisplayer(selectTarget);
            $("#select-tag-name").css("display", "");
            $selectBox = $('#select-box');
            $selectBox.css({
                height: (rect.height + 8) + "px",
                width: (rect.width + 8) + "px",
                top: (rect.top - 2) + "px",
                left: (rect.left - 2) + "px",
                display: 'block',
            });
            $controlPanel = $('#select-actions');
            $controlPanel.css({
                display: 'block',
            });
            if (event.target.tagName.toLocaleLowerCase() === 'body') {
                $controlPanel.css({
                    display: 'none',
                });
            }

            //Adding offset value to the select-box when scroll event happened
            var x = parseInt($selectBox.css('top'));
            var y = parseInt($selectBox.css('left'));
            var topPosition = $($(".drop").get(0).contentWindow).scrollTop();
            var leftPosition = $($(".drop").get(0).contentWindow).scrollLeft();
            $($(".drop").get(0).contentWindow).scroll(function () {
                $selectBox.css({
                    top: (x + (topPosition - $($(".drop").get(0).contentWindow).scrollTop())) + "px",
                    left: (y + (leftPosition - $($(".drop").get(0).contentWindow).scrollLeft())) + "px",
                })
            })
        }
    });

    /**
     * This method will detect the mouse location, it will mark the content (e.g div, form, etc.) when mouse
     * are located in the top of a content, remove the mark when mouse left
     * @param event
     */
    function handler(event) {
        if (event.target) {
            prev = event.target;
            if (event.target.tagName.toLocaleLowerCase() !== 'html') {
                var rect = prev.getBoundingClientRect();
                $contextMarker.css({
                    height: (rect.height + 4) + "px",
                    width: (rect.width + 4) + "px",
                    top: (rect.top + $(frameWindow).scrollTop() - 2) + "px",
                    left: (rect.left + $(frameWindow).scrollLeft() - 2) + "px"
                });
                if (rect.top + $(".drop").contents().find("body").scrollTop() < 24)
                    $contextMarker.find("[data-dragcontext-marker-text]").css('top', '0px');
                else
                    $contextMarker.find("[data-dragcontext-marker-text]").css('top', '-24px');
                //show the tag name in marker
                var name = prev.tagName;
                $contextMarker.find('[data-dragcontext-marker-text]').html(name);
                $contextMarker.attr("data-dragcontext-marker", name.toLowerCase());
                if ($(".drop").contents().find("body [data-sh-parent-marker]").length != 0)
                    $(".drop").contents().find("body [data-sh-parent-marker]").first().before($contextMarker);
                else
                    $(".drop").contents().find("body").append($contextMarker);
            }
        }
    }

});

/**
 * After attributes were changed, the select-box needs resize
 * @param element
 */
function resizeSelectBox(element) {
    var rect = element.getBoundingClientRect();
    $selectBox = $('#select-box');
    $selectBox.css({
        height: (rect.height + 8) + "px",
        width: (rect.width + 8) + "px",
        top: (rect.top - 2) + "px",
        left: (rect.left - 2) + "px",
        display: 'block',
    });
    //Update the code in the drag element
    $("#drag-content").attr('data-insert-html', element.outerHTML);
    //Update changed element to the selectTarget in dragdrop.js
    selectTarget = element;
    updateTagNameDisplayer(selectTarget);
}

/**
 * A pre-code style insert into the iframe page
 * @returns CSS style code
 * @constructor
 */
GetInsertionCSS = function () {
    var styles = "img, a {user-select: none;-webkit-user-drag: none;}" +
        ".reserved-drop-marker{width:100%;height:2px;background:#00a8ff;position:absolute}.reserved-drop-marker::after,.reserved-drop-marker::before{content:'';background:#00a8ff;height:7px;width:7px;position:absolute;border-radius:50%;top:-2px}.reserved-drop-marker::before{left:0}.reserved-drop-marker::after{right:0}";
    styles += "[data-dragcontext-marker],[data-sh-parent-marker]{outline:#19cd9d solid 2px;text-align:center;position:absolute;z-index:123456781;pointer-events:none;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif}[data-dragcontext-marker] [data-dragcontext-marker-text],[data-sh-parent-marker] [data-sh-parent-marker-text]{background:#19cd9d;color:#fff;padding:2px 10px;display:inline-block;font-size:14px;position:relative;top:-24px;min-width:121px;font-weight:700;pointer-events:none;z-index:123456782}[data-dragcontext-marker].invalid{outline:#dc044f solid 2px}[data-dragcontext-marker].invalid [data-dragcontext-marker-text]{background:#dc044f}[data-dragcontext-marker=body]{outline-offset:-2px}[data-dragcontext-marker=body] [data-dragcontext-marker-text]{top:0;}";
    styles += '.drop-marker{pointer-events:none;}.drop-marker.horizontal{background:#00adff;position:absolute;height:2px;list-style:none;visibility:visible!important;box-shadow:0 1px 2px rgba(255,255,255,.4),0 -1px 2px rgba(255,255,255,.4);z-index:123456789;text-align:center}.drop-marker.horizontal.topside{margin-top:0}.drop-marker.horizontal.bottomside{margin-top:2px}.drop-marker.horizontal:before{content:"";width:8px;height:8px;background:#00adff;border-radius:8px;margin-top:-3px;float:left;box-shadow:0 1px 2px rgba(255,255,255,.4),0 -1px 2px rgba(255,255,255,.4)}.drop-marker.horizontal:after{content:"";width:8px;height:8px;background:#00adff;border-radius:8px;margin-top:-3px;float:right;box-shadow:0 1px 2px rgba(255,255,255,.4),0 -1px 2px rgba(255,255,255,.4)}.drop-marker.vertical{height:50px;list-style:none;border:1px solid #00ADFF;position:absolute;margin-left:3px;display:inline;box-shadow:1px 0 2px rgba(255,255,255,.4),-1px 0 2px rgba(255,255,255,.4)}.drop-marker.vertical.leftside{margin-left:0}.drop-marker.vertical.rightside{margin-left:3px}.drop-marker.vertical:before{content:"";width:8px;height:8px;background:#00adff;border-radius:8px;margin-top:-4px;top:0;position:absolute;margin-left:-4px;box-shadow:1px 0 2px rgba(255,255,255,.4),-1px 0 2px rgba(255,255,255,.4)}.drop-marker.vertical:after{content:"";width:8px;height:8px;background:#00adff;border-radius:8px;margin-left:-4px;bottom:-4px;position:absolute;box-shadow:1px 0 2px rgba(255,255,255,.4),-1px 0 2px rgba(255,255,255,.4)}';
    return styles;

};

/**
 * Parent Button click
 */
$("#parent-btn").on("click", function (event) {
    event.preventDefault();
    var parent = $(selectTarget).get(0).parentElement;
    var tagName = $(parent).prop("tagName").toLowerCase();
    if (tagName != 'body' && tagName != 'html') {
        resizeSelectBox($(selectTarget).get(0).parentElement);
        attributeDisplayUpdater();
    } else {
        //Show that you reached the edge
    }
});

/**
 * Clone Button click
 */
$("#clone-btn").on("click", function (event) {
    event.preventDefault();
    var clone = $(selectTarget).clone();
    $(selectTarget).after(clone);
    resizeSelectBox(selectTarget);
});

/**
 * Delete Button click
 */
$("#delete-btn").on("click", function (event) {
    event.preventDefault();
    $(selectTarget).remove()
    // $("#select-actions").css("display", "none");
    $("#select-box").css("display", "none");
});

/**
 * Bold Button click
 */
$("#bold-btn").on("click", function (event) {
    event.preventDefault();
    console.log($(".drop").get(0).contentWindow.document.execCommand('bold', false, null));
});

/**
 * Italic Button click
 */
$("#italic-btn").on("click", function (event) {
    event.preventDefault();
    console.log($(".drop").get(0).contentWindow.document.execCommand('italic', false, null));
});

/**
 * Underline Button click
 */
$("#underline-btn").on("click", function (event) {
    event.preventDefault();
    console.log($(".drop").get(0).contentWindow.document.execCommand('underline', false, null));
});

/**
 * Show the current selected element's tag name
 * @param element
 */
function updateTagNameDisplayer(element) {
    $("#tag-name").text("<" + element.tagName + ">");
}

/*
    --------------------------------------------------------------------------------------------------------------------
                                                       Vex-Page END
 */

/*
                                                   Vex-Component START
    --------------------------------------------------------------------------------------------------------------------
 */


/**
 * Search component
 */
$("#component-search").on("keyup", function () {
    var value = $(this).val().toLowerCase();
    filterUl(value);

});

/**
 * Filter the components by input the keyword
 * @param value
 */
function filterUl(value) {
    var list = $("#drag-list-container li").hide()
        .filter(function () {
            var item = $(this).text();
            var padrao = new RegExp(value, "i");
            return padrao.test(item);
        }).closest("li").show();
};

/**
 * Reset search button
 */
$("#clear-component-search-input").on("click", function () {
    $("#component-search").val("");
    filterUl("");
});

/*
    --------------------------------------------------------------------------------------------------------------------
                                                  Vex-Component END
 */


/*
                                                Vex-Project-List START
    --------------------------------------------------------------------------------------------------------------------
 */

/**
 * This method will send Ajax request to PHP server
 * Update the page's live status
 * @param event
 */
function changeLiveStatus(event) {
    var productId = $(event.target).attr("productId");
    var checked = $(event.target).is(":checked");
    $.ajax({
        type: "POST",
        url: "./lib/updateLive.php",
        data: {
            id: productId,
            value: checked
        },
        success: function (data) {
            var data = JSON.parse(data);
            if (data.status == true) {
                alert(data.msg);
            } else {
                alert("Error Code: " + data.code + "\nDescription: " + data.msg);
                $(event.target).attr("checked", !checked);
            }
        },
    });
}

/**
 * This method will change the page and shown in iframe
 * @param id
 */
function loadPage(id) {
    $(".drop").attr("src", "page.php?id=" + id);
    $(".drop").attr("product-id", id);
}

/**
 * Calling this method will sending the delete request through Ajax,
 * it will assign the product's 'is_delete' to TRUE
 * @param event
 */
function deleteProduct(event) {
    var productId = $(event.target).attr("productId");
    var parent = $($(event.target).get(0).parentElement).get(0).parentElement;
    $.ajax({
        type: "POST",
        url: "./lib/deletePage.php",
        data: {
            id: productId,
        },
        success: function (data) {
            var data = JSON.parse(data);
            if (data.status == true) {
                alert(data.msg);
                $(parent).remove();
            } else {
                alert("Error Code: " + data.code + "\nDescription: " + data.msg);
            }
        },
    });
}

/**
 * This method will return the product URL
 * @param id
 */
function shareURL(id) {
    var hostname = window.location.href.substring(0, window.location.href.indexOf("editor.php"));
    var URL = hostname + "page.php?id=" + id;
    alert(URL);
}

/**
 * This method will passing the html code into backend through Ajax requests
 * PHP server will receive the requests and insert/update database
 * @param event
 */
function saveOrUpdate(event) {
    var id = $(".drop").attr("product-id");
    var productName = $("#product-id-" + id).html() == undefined ? "My Page" : $("#product-id-" + id).html();
    var isCreate = id == "";
    var url = "./lib/savePage.php";

    var page = $(".drop").contents().find("html").clone();
    $(page).find("[data-reserved-styletag]").remove();
    $(page).find("[data-dragcontext-marker]").remove();
    page = "<!DOCTYPE html><html>" + $(page).html() + "</html>";
    $.ajax({
        type: "POST",
        url: url,
        data: {
            type: isCreate ? "save" : "update",
            id: id,
            name: productName,
            page: page,
        },
        success: function (data) {
            var data = JSON.parse(data);
            if (data.status == true) {
                alert(data.msg);
            } else {
                alert("Error Code: " + data.code + "\nDescription: " + data.msg);
            }
        }
    });
}

/*
    --------------------------------------------------------------------------------------------------------------------
                                                    Vex-Project-List END
 */