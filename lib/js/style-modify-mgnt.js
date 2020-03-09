//TODO
var element;
$("#drag-list-container li, #drag-content").on("dragstart", function () {
    //alert("Hide");
    element = undefined;
});

$($(".drop").get(0).contentWindow).on("click", function (event) {
    //TODO show style options
    //TODO fetch the style attribute from event.target and
    element = event.target;
    $('#display-style').val($(element).css('display'));

});

/**
 * Double click edit the context
 */
$($(".drop").get(0).contentWindow).on("dblclick", function (event) {
    //Hide the select-box
    $("#select-box").css("display", "none");
    //Set this element Editable
    $(event.target).attr("contenteditable", "true");
    //Remove the Editable attribute, once the mouse click other than the editable element
    $(event.target).on("blur, focusout", function () {
        $(event.target).removeAttr("contenteditable");
    });
});

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


function setOriginalValue(event) {
    $(this).data('originalValue', $(this).val());
}

function changeAttribute(event) {
    var prev = $(this).data('originalValue');
    var attr = $(this).attr('style-data-type');
    console.log("Tag name: " + element.tagName + ", Attribute: " + attr + ", Orig: " + prev + ", New:" + this.value);
    $(element).css(attr, this.value);
    resizeSelectBox(element);

}

$('select').on('focusin', setOriginalValue);

$('select').on('change', changeAttribute);