/**
 * This class will be able modify the tag's context, attributes and style attributes
 */
var element;
var selectOption = [];
var editElement = undefined;
var origText = "";

$(".default-tab").css('display', 'none');
$(".default-hide-tab").css('display', 'none');


//Click button to upload image/video
$(".upload-btn").on("change", uploadFile);

//Onload hide all tabs
$(".drop").on("load", function () {
    hideToolbar();
    $("form :input").keypress(
        function (event) {
            if (event.which == '13') {
                event.preventDefault();
            }
        });
    /**
     * Add event listener for changing the attributes
     */
    $('.element-style, .element-attribute').on('focusin', setOriginalValue);

    $('.element-style').on('change', changeStyleAttribute);

    $('.element-attribute').on('change', changeAttribute);

//Once start drag element, re-initialization
    $("#drag-list-container li").on("dragstart", dragEventDataReset);


    /**
     * This onclick listener will fetch the tag attribute and style attribute
     */
    $($(".drop").get(0).contentWindow).on("click", attributeDisplayUpdater);


    /**
     * Double click edit the context
     */
    $($(".drop").get(0).contentWindow).on("dblclick", function (event) {
        event.stopPropagation();
        if (event.target.tagName.toLocaleLowerCase() == 'html') {
            return
        }
        //Hide the select-box
        editElement = element;
        $("#select-editor").css("display", "");
        $("#select-actions").css("display", "none");
        $("#select-tag-name").css("display", "none");
        //Set this element Editable
        $(event.target).attr("contenteditable", "true");
        //Get only the parent text
        origText = $(event.target).clone().children().remove().end().text();

        //Remove the Editable attribute, once the mouse click other than the editable element
        $(event.target).focus().on("click", function (e) {
            if (element !== $(e.target).get(0)) {
                $("#select-editor").css("display", "none");
                removeEditAttribute(editElement);
            }
        });
    });
});

/**
 * This method will show the available tabs
 */
function attributeDisplayUpdater() {
    if (selectTarget.tagName.toLocaleLowerCase() == 'html') {
        return
    }
    element = selectTarget;
    // It will remove the editable attribute, once click outside of the element
    if (editElement !== undefined && editElement !== element) {
        $("#select-editor").css("display", "none");
        removeEditAttribute(editElement);
        editElement = undefined;
    }
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
        case "table":
            loadTableSize(element);
            $("#table-tab").css('display', '');
            break;
        case "input":
            loadAttributes(element, tagName);
            $("#input-tab").css('display', '');
        default:
            loadAttributes(element);
    }
    $("#drag-content").on("dragstart", dragEventDataReset);
}

/**
 * Remove the editable attribute
 * @param element
 */
function removeEditAttribute(element) {
    $(editElement).removeAttr("contenteditable");
    var newText = $(editElement).clone().children().remove().end().text();
    if (origText !== newText) {
        console.log("Tag name: " + element.tagName + ", Text Orig: '" + origText + "', New:'" + newText + "'");
    }
    $(editElement).off("blur, focusout, click");
}

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
                //if it is a style attribute
                if (attributeName === "style") {
                    loadStyleAttribute(attributeValue);
                } else {
                    if (attributeValue == "disabled" || attributeValue == "true" || attributeValue == "loop" || attributeValue == "autoplay" || attributeValue == "controls") {
                        $("#attribute-" + tagName + "-" + attributeName).prop('checked', true);
                    }
                    if (tagName != null) {
                        $("#attribute-" + tagName + "-" + attributeName).val(attributeValue);
                    }
                    //default attribute
                    $("#attribute-" + attributeName).val(attributeValue)
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

function dragEventDataReset() {
    element = undefined;
    //hide
    hideToolbar();
    resetData();
}

/**
 * Load style attribute in the style-attribute-toolbar
 * @param styleAttributes
 */
function loadStyleAttribute(styleAttributes) {
    var styleList = getStyleAttribute(styleAttributes);
    for (var i = 0; i < styleList.length; i++) {
        if (styleList[i].name === "padding" || styleList[i].name === "margin") {
            // It may have padding and margin instead of padding-top, padding-bottom, ....
            // It need convert the value if only the style has padding/margin prop.
            var values = styleList[i].value.replace(";", "").split(" ");
            switch (values.length) {
                case 1:
                    $("#style-" + styleList[i].name + "-top").val(values[0]);
                    $("#style-" + styleList[i].name + "-bottom").val(values[0]);
                    $("#style-" + styleList[i].name + "-left").val(values[0]);
                    $("#style-" + styleList[i].name + "-right").val(values[0]);
                    break;
                case 2:
                    $("#style-" + styleList[i].name + "-top").val(values[0]);
                    $("#style-" + styleList[i].name + "-bottom").val(values[0]);
                    $("#style-" + styleList[i].name + "-left").val(values[1]);
                    $("#style-" + styleList[i].name + "-right").val(values[1]);
                    break;
                case 3:
                    $("#style-" + styleList[i].name + "-top").val(values[0]);
                    $("#style-" + styleList[i].name + "-bottom").val(values[1]);
                    $("#style-" + styleList[i].name + "-left").val(values[1]);
                    $("#style-" + styleList[i].name + "-right").val(values[2]);
                    break;
                case 4:
                    $("#style-" + styleList[i].name + "-top").val(values[0]);
                    $("#style-" + styleList[i].name + "-bottom").val(values[1]);
                    $("#style-" + styleList[i].name + "-left").val(values[2]);
                    $("#style-" + styleList[i].name + "-right").val(values[3]);
                    break;
            }
        } else if (styleList[i].name === "border") {
            var values = styleList[i].value.replace(";", "").split(" ");
            $("#style-border-style").val(values[1]);
            $("#style-border-width").val(values[0]);
            $("#style-border-color").val(rgb2hex(values[2]));
        } else if (styleList[i].name === "border-radius") {
            // Convert border-radius
            $("#style-border-top-left-radius").val(styleList[i].value);
            $("#style-border-top-right-radius").val(styleList[i].value);
            $("#style-border-bottom-left-radius").val(styleList[i].value);
            $("#style-border-bottom-right-radius").val(styleList[i].value);
        } else if (styleList[i].name === "background-position") {
            // Convert background-position
            var values = styleList[i].value.replace(";", "").split(" ");
            $("#style-" + styleList[i].name + "-x").val(values[0]);
            $("#style-" + styleList[i].name + "-y").val(values[1]);
        } else if (styleList[i].name === "background-image") {
            // If the background-img style attribute, background-img: url(xxxx), only get value between ()
            $("#style-" + styleList[i].name).val(styleList[i].value.slice(5, -2));
        } else if (styleList[i].name.includes("color")) {
            var hexColour = rgb2hex(styleList[i].value);
            $("#style-" + styleList[i].name).val(hexColour);
        } else {
            $("#style-" + styleList[i].name).val(styleList[i].value);
        }
    }
}

/**
 * Change rgb value to hex
 *  rgb(255,255,255) => #ffffff
 * @param rgb
 * @returns {string}
 */
function rgb2hex(rgb) {
    var rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);

    function hex(x) {
        return ("0" + parseInt(x).toString(16)).slice(-2);
    }

    return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
}

/**
 * This method will return a list of style attributes
 * @param styleAttributes
 * @returns {*|string[]}
 */
function getStyleAttribute(styleAttributes) {
    var list = styleAttributes.split("; ");
    var styleObjectList = [];
    for (var i = 0; i < list.length; i++) {
        try {
            var temp = list[i].split(": ");
            if (temp[0].trim() !== "") {
                styleObjectList.push({"name": temp[0].trim(), "value": temp[1].replace(";", "")});
            }
        } catch (e) {
            var temp = list[i].split(":");
            if (temp[0].trim() !== "") {
                styleObjectList.push({"name": temp[0].trim(), "value": temp[1].replace(";", "")});
            }
        }
    }
    return styleObjectList;
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
    $(".element-style:input:not(#style-opacity,#style-background-color,#style-color,#style-text-decoration-color,#style-border-color)").val("");
    $(".element-attribute").val("");
    $("#style-opacity").val(1);
    $("#style-background-color,#style-text-decoration-color").val("#ffffff");
    $("#style-color,#style-border-color").val("#000000");
    $(".element-attribute:input[type=checkbox]").prop('checked', false);
    $("#select-option").empty();
    $("input[type=file]").val("");
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
    var prev = $(this).data('originalValue');
    var attr = $(this).attr('style-data-type');
    console.log("Tag name: " + element.tagName + ", Style Attribute: " + attr + ", Orig: " + prev + ", New:" + this.value);
    if (attr === "background-image") {
        $(element).css(attr, "url(" + this.value + ")");
    } else {
        $(element).css(attr, this.value);
    }

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
        //Copy the attributes to new
        $(element).each(function () {
            $.each(this.attributes, function (i, attrib) {
                $(newElement).attr(attrib.name, attrib.value);
            });
        });
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
    //update the selectOption list
    loadOptionsList(element);
    resizeSelectBox(element);
}


/**
 * After click the delete button in select tab, it will remove the option
 * @param event
 */
function removeOption(event) {
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
            "    <form class='form-horizontal'><label class='text-nowrap d-inline col-sm-2'>Option " + (i + 1) + "</label></form>\n" +
            "    <form class='form-horizontal'>\n" +
            "        <div class='form-group'><label class='text-nowrap d-inline col-sm-2'>Value</label>\n" +
            "            <div class='col-sm-10'><input type='text' class='form-control' attr-data-type='value' attr-data-position='" + i + "' onchange='changeOptionAttribute(event)' value='" + val.value + "'/></div>\n" +
            "        </div>\n" +
            "    </form>\n" +
            "    <form class='form-horizontal'>\n" +
            "        <div class='form-group'><label class='text-nowrap d-inline col-sm-2'>Text</label>\n" +
            "            <div class='col-sm-10'><input type='text' class='form-control' attr-data-type='text' attr-data-position='" + i + "' onchange='changeOptionAttribute(event)' value='" + val.name + "'/>" +
            "                   <br /><button class='btn btn-primary text-right select-remove' type='button' onclick='removeOption(event)' style='background-color: rgb(255,0,0);' attr-data-type='" + i + "'>Remove</button></div>\n" +
            "        </div>\n" +
            "    </form>\n" +
            "</div><br/>";
        $("#select-option").append(template);
    });
}

/**
 * This method will convert image/video to base64 and set attribute/style-attribute
 * @param event
 */
function uploadFile(event) {
    var fileTypes = ['jpg', 'jpeg', 'png', 'svg'];
    if (this.files && this.files[0]) {
        var extension = this.files[0].name.split('.').pop().toLowerCase(),  //file extension from input file
            isSuccess = fileTypes.indexOf(extension) > -1,
            FileSize = this.files[0].size / 1024 / 1024;
        if (FileSize > 5) {
            swal("File Oversize", "File size exceeds 5 MB.", "error");
            $(event.target).val("");
        } else if (isSuccess) {
            var FR = new FileReader();
            FR.addEventListener("load", function (e) {
                $.ajax({
                    type: "POST",
                    url: "./lib/upload.php",
                    data: {
                        data: e.target.result,
                        extension: extension,
                    },
                    success: function (data) {
                        console.log(data);
                        var data = JSON.parse(data);

                        if (data.status == true) {
                            var hostname = window.location.href.slice(0, window.location.href.indexOf("/editor.php"));
                            console.log(hostname);
                            if ($(event.target).attr("attr-type") === "attribute") {
                                $(element).attr($(event.target).attr("data-type"), hostname + data.msg);
                            } else {
                                $(element).css($(event.target).attr("data-type"), "url(\"" + hostname + data.msg + "\"");
                            }
                        } else {
                            swal("Failed!", "Error Code: " + data.code + "\nDescription: " + data.msg, "error");
                        }
                    },
                });

            });
            FR.readAsDataURL(this.files[0]);
        } else {
            swal("File type incorrect", "We only support jpg, jpeg, png, svg format.", "error");
        }

    }
}

/**
 * After click the add option button,
 * It will add option into the list
 * and add option to the selectOption
 */
$("#select-add-btn").on("click", function () {
    var option = {"value": "value", "name": "text"};
    selectOption.push(option);
    var newOption = new Option("name", "value");
    // Append it to the select
    $(element).append(newOption).trigger('change');
    renderOptionList();
    resizeSelectBox(element);
});

/**
 * Resize table tag
 */
$("#table-resize-btn").on("click", function () {
    var $oldTable = $(element);
    var $table = $('<table>');
    var width = $('#table-col').val();
    var height = $('#table-row').val();


    for (var row = 0; row < height; row++) {
        // if ($oldTable.get(row)!= null)
        var $tr = $('<tr>');
        for (var column = 0; column < width; column++) {
            var $td = $('<td>');
            $td.html(getCellValue($oldTable, row, column));
            $tr.append($td);
        }
        $table.append($tr);
    }
    $oldTable.after($table);
    var newElement = $(element).get(0).nextSibling;
    $(element).replaceWith("");
    element = newElement;
    resizeSelectBox(element);
});

function getCellValue($table, row, col) {
    var $trs = $table.find('tr');
    console.log($($trs));
    return $trs.length > row && $($trs[row]).find('td').length > col
        ? $($($trs[row]).find('td')[col]).html() : ("cell" + row + "," + col);
}

function getNumRowCol($table) {
    var row = $($table).get(0).rows;
    var col = row[0].cells;
    return [row.length, col.length];
}

function loadTableSize($table) {
    var tableSize = getNumRowCol($table);
    $("#table-row").val(tableSize[0]);
    $("#table-col").val(tableSize[1]);
}


// $('.drop').ready( hideToolbar);

