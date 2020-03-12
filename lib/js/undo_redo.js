var undo_manager = new UndoManager();
var undoBtn = document.getElementById('undo');
var redoBtn = document.getElementById('redo');


undoBtn.addEventListener('click', function() {
    undo_manager.undo();
    updateUndoUI();
});

redoBtn.addEventListener('click', function() {
    undo_manager.redo();
    updateUndoUI();
});

function updateUndoUI() {
    undoBtn.classList[undo_manager.hasUndo() ? 'remove' : 'add']('disable');
    redoBtn.classList[undo_manager.hasRedo() ? 'remove' : 'add']('disable');
}

function afterdrop(referred_item, added_item, location){
    console.log("drop end");
    console.log(added_item);
    undo_manager.add({
        undo: function(){
            added_item.remove()
        },
        redo: function(){
            if (location == "after"){
                referred_item.after(added_item);
            }
            else{
                referred_item.before(added_item);
            }
        }
    })
    updateUndoUI();
}