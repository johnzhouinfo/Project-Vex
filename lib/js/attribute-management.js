/**
 * This class will be able modify the tag's context, attributes and style attributes
 */
var element;
var selectOption = [];
//Onload hide all tabs
$(this).on("load", hideToolbar);

/**
 * Add event listener for changing the attributes
 */
$('.element-style, .element-attribute').on('focusin', setOriginalValue);

$('.element-style').on('change', changeStyleAttribute);

$('.element-attribute').on('change', changeAttribute);


//TODO needs upload button listener, have a convert function which can convert pic/video to base64

/**
 * Once start drag element, reinitialization
 */
$("#drag-list-container li, #drag-content").on("dragstart", function () {
    element = undefined;
    //hide
    hideToolbar();
    resetData();
});

/**
 * This onclick listener will fetch the tag attribute and style attribute
 */
$($(".drop").get(0).contentWindow).on("click", function (event) {
    //TODO show style options
    //TODO fetch the style attribute from event.target and
    element = event.target;
    hideToolbar();
    resetData();
    //show default-tab
    $(".default-tab").css('display', '');
    //show specific tag
    var tagName = getTagName(element);
    switch (tagName) {
        case "h1":
        case "h2":
        case "h3":
        case "h4":
        case "h5":
        case "h6":
            $("#heading-tab").css('display', '');
            loadAttributes(element, tagName, tagName.charAt(1).toString());
            break;
        case "button":
            $("#button-tab").css('display', '');
            loadAttributes(element, tagName);
            break;
        case "a":
            $("#link-tab").css('display', '');
            loadAttributes(element, tagName);
            break;
        case "video":
            $("#video-tab").css('display', '');
            loadAttributes(element, tagName);
            break;
        case "img":
            $("#image-tab").css('display', '');
            loadAttributes(element, tagName);
            break;
        case "form":
            $("#form-tab").css('display', '');
            loadAttributes(element, tagName);
            break;
        case "select":
            loadOptionsList(element);
            $("#select-tab").css('display', '');
            break;
        default:
            loadAttributes(element);
    }
});

/**
 * Double click edit the context
 */
$($(".drop").get(0).contentWindow).on("dblclick", function (event) {
    event.stopPropagation();
    //Hide the select-box
    $("#select-box").css("display", "none");
    //Set this element Editable
    $(event.target).attr("contenteditable", "true");
    //Get only the parent text
    var origText = $(event.target).clone().children().remove().end().text();

    //Remove the Editable attribute, once the mouse click other than the editable element
    $(event.target).focus().on("blur, focusout", function (e) {
        removeEditAttribute();
    }).on("click", function (e) {
        if (element !== $(e.target).get(0)) {
            removeEditAttribute();
        }
    });

    function removeEditAttribute() {
        $(event.target).removeAttr("contenteditable");
        var newText = $(event.target).clone().children().remove().end().text();
        if (origText !== newText) {
            console.log("Tag name: " + element.tagName + ", Text Orig: '" + origText + "', New:'" + newText + "'");
        }
        $(event.target).off("blur, focusout, click");
    }

});

/**
 * This method will load the attributes into the toolbar
 * @param element (require)
 * @param tagName (option) for those tags have same attributes, e.g. img.width and video.width
 * @param headingValue (option) for changing heading size
 */
function loadAttributes(element, tagName, headingValue) {
    //Load attributes
    $(element).each(function () {
        //Load for heading attribute
        if (headingValue !== undefined) {
            $("#attribute-size").val(headingValue);
        }
        $.each(this.attributes, function () {
            // this.attributes is not a plain object, but an array
            // of attribute nodes, which contain both the name and value
            if (this.specified) {
                var attributeName = this.name.toLowerCase();
                var attributeValue = this.value.toLowerCase();
                console.log(attributeName);
                //if it is a style attribute
                if (attributeName === "style") {
                    //TODO load style attribute
                    getStyleAttribute(attributeValue);
                } else {
                    if (attributeValue == "disabled" || attributeValue == "true" || attributeValue == "loop" || attributeValue == "autoplay" || attributeValue == "controls") {
                        $("#attribute-" + tagName + "-" + attributeName).prop('checked', true);
                    }
                    if (tagName != null) {
                        $("#attribute-" + tagName + "-" + attributeName).val(attributeValue);
                    } else {
                        //default attribute
                        $("#attribute-" + attributeName).val(attributeValue);
                    }
                }
            }
        });
    });
}

/**
 * This method will load option attribute in the select tag into the select-tab toolbar
 * selectOption
 * @param element
 */
function loadOptionsList(element) {
    selectOption = [];
    $.each($(element).get(0).options, function (i, val) {
        var option = {"value": val.value, "name": val.text};
        selectOption.push(option);
    });
    renderOptionList();
}

/**
 * This method will return a list of style attributes
 * @param styleAttributes
 * @returns {*|string[]}
 */
function getStyleAttribute(styleAttributes) {
    //TODO return a style object list {[height, 15px],[width, 20px],...}
    var list = styleAttributes.split(";");
    console.log(list);
}

/**
 * This method will hide all the tabs
 */
function hideToolbar() {
    $(".default-tab").css('display', 'none');
    $(".default-hide-tab").css('display', 'none');
}

/**
 * This method will reset the value to default
 */
function resetData() {
    $("select").prop('selectedIndex', 0);
    $("input:not(#style-opacity,#style-background-color,#style-color,#style-text-decoration-color,#style-border-color)").val("");
    $("#style-opacity").val(1);
    $("#style-background-color,#style-text-decoration-color,#style-border-color").val("#ffffff");
    $("#style-color").val("#000000");
    $("[type=checkbox]").prop('checked', false);
    $("#select-option").empty();
    selectOption = [];
}

/**
 * Return tag name
 * @param element
 * @returns {string | jQuery}
 */
function getTagName(element) {
    return $(element).prop("tagName").toLowerCase();
}

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
}

/**
 * Store the original value of this object
 * @param event
 */
function setOriginalValue(event) {
    $(this).data('originalValue', $(this).val());
}

/**
 * This method will change the style attribute of the tag
 * @param event
 */
function changeStyleAttribute(event) {
    //TODO some attributes need to have extra condition, e.g background-pic, unit
    var prev = $(this).data('originalValue');
    var attr = $(this).attr('style-data-type');
    console.log("Tag name: " + element.tagName + ", Style Attribute: " + attr + ", Orig: " + prev + ", New:" + this.value);
    $(element).css(attr, this.value);
    resizeSelectBox(element);

}

/**
 * This method will change the attribute of the tag
 * @param event
 */
function changeAttribute(event) {
    var prev = $(this).data('originalValue');
    var attr = $(this).attr('attr-data-type');
    var type = $(this).attr("type");
    var newValue = this.value;

    if (type === "checkbox") {
        var state = $(this).is(":checked");
        $(element).attr(attr, state);
        console.log("Tag name: " + element.tagName + ", Attribute: " + attr + ", Orig: " + !state + ", New:" + state);
    } else if (attr === "text") {
        $(element).text(newValue);
        console.log("Tag name: " + element.tagName + ", Text Orig: '" + prev + "', New: '" + this.value + "'");
    } else if (this.value.length === 0) {
        $(element).removeAttr(attr);
        console.log("Tag name: " + element.tagName + ", RM Attribute: " + attr);
    } else if (attr === "heading-size") {
        //change heading size
        $(element).after("<h" + newValue + ">" + $(element).text() + "</h" + newValue + ">");
        var newElement = $(element).get(0).nextSibling;
        $(element).replaceWith("");
        element = newElement;
        console.log("Tag name: " + element.tagName + ", New: h" + this.value);
    } else {
        $(element).prop(attr, newValue);
        console.log("Tag name: " + element.tagName + ", Attribute: " + attr + ", Orig: " + prev + ", New:" + this.value);
    }
    resizeSelectBox(element);
}

/**
 * An onChange event listener will be added in the select tab
 * Changing the option attribute and text
 * @param event
 */
function changeOptionAttribute(event) {

    var target = $(event.target).attr("attr-data-position");
    var type = $(event.target).attr("attr-data-type");
    if (type === "text") {
        $(element).find("option:eq(" + target + ")").text(event.target.value);
    } else {
        $(element).find("option:eq(" + target + ")").attr('value', event.target.value);
    }
    loadOptionsList(element);
    resizeSelectBox(element);
}

/**
 * After click the add option button,
 * It will add option into the list
 * and add option to the selectOption
 */
$("#select-add-button").on("click", function () {
    var option = {"value": "value", "name": "text"};
    selectOption.push(option);
    var newOption = new Option("name", "value");
    // Append it to the select
    $(element).append(newOption).trigger('change');
    renderOptionList();
});

/**
 * After click the delete button in select tab, it will remove the option
 * @param event
 */
function removeSelect(event) {
    var target = event.target.attributes[4].value;
    selectOption.splice(target, 1);
    //remove the target internet
    $(element).find("option:eq(" + target + ")").remove();
    renderOptionList();
}

/**
 * Render the option list in the select-attribute toolbar
 */
function renderOptionList() {
    $("#select-option").empty();
    jQuery.each(selectOption, function (i, val) {
        var template = "<div class='border rounded border-primary d-flex' id='option-" + i + "'>\n" +
            "    <form class='form-horizontal' action='#'><label class='text-nowrap d-inline col-sm-2'>Option " + (i + 1) + "</label></form>\n" +
            "    <form class='form-horizontal' action='#'>\n" +
            "        <div class='form-group'><label class='text-nowrap d-inline col-sm-2'>Value</label>\n" +
            "            <div class='col-sm-10'><input type='text' class='form-control' attr-data-type='value' attr-data-position='" + i + "' onchange='changeOptionAttribute(event)' value='" + val.value + "'/></div>\n" +
            "        </div>\n" +
            "    </form>\n" +
            "    <form class='form-horizontal' action='#'>\n" +
            "        <div class='form-group'><label class='text-nowrap d-inline col-sm-2'>Text</label>\n" +
            "            <div class='col-sm-10'><input type='text' class='form-control' attr-data-type='text' attr-data-position='" + i + "' onchange='changeOptionAttribute(event)' value='" + val.name + "'/>" +
            "                   <br /><button class='btn btn-primary text-right select-remove' type='button' onclick='removeSelect(event)' style='background-color: rgb(255,0,0);' attr-data-type='" + i + "'>Remove</button></div>\n" +
            "        </div>\n" +
            "    </form>\n" +
            "</div><br/>";
        $("#select-option").append(template);
    });
}