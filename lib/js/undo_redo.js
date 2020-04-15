var undo_manager = new UndoManager();
var undoBtn = document.getElementById('undo');
var redoBtn = document.getElementById('redo');

/**
 * Add listener when click undo btn
 */
undoBtn.addEventListener('click', function () {
    $(".drop").contents().find("[data-dragcontext-marker]").remove();
    undo_manager.undo();
    updateUndoUI();
});

/**
 * Add listener when click redo btn
 */
redoBtn.addEventListener('click', function () {
    $(".drop").contents().find("[data-dragcontext-marker]").remove();
    undo_manager.redo();
    updateUndoUI();
});

/**
 * Update the btns states
 */
function updateUndoUI() {
    undoBtn.classList[undo_manager.hasUndo() ? 'remove' : 'add']('disable');
    redoBtn.classList[undo_manager.hasRedo() ? 'remove' : 'add']('disable');
}

/**
 *
 * @param old_data original data
 * @param new_data changed data
 */
function setUndoRedoEvent(old_data, new_data) {
    old_data.find("[data-dragcontext-marker]").remove();
    new_data.find("[data-dragcontext-marker]").remove();
    if (old_data == null || new_data == null) {
        return;
    }
    undo_manager.add({
        undo: function () {
            var page = $(".drop").contents().find("body");
            page.replaceWith(old_data);
            hideSelectedBox();
            dragEventDataReset();
        },
        redo: function () {
            var page = $(".drop").contents().find("body");
            page.replaceWith(new_data);
            hideSelectedBox();
            dragEventDataReset();
        }
    });

    updateUndoUI();
}