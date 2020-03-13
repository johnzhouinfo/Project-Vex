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

function afterdrop(referred_item, added_item, location, old_refer_item, old_location){
    console.log("drop end");
    console.log(added_item);
    undo_manager.add({
        undo: function(){
            added_item.remove();
            if (old_refer_item != null){
                if (old_location == "after"){
                    old_refer_item.after(added_item);
                }
                if (old_location == "before"){
                    old_refer_item.before(added_item);
                }
            }
        },
        redo: function(){
            if (old_refer_item != null){
                added_item.remove();    //remove old item must execute before add it back to new location
            } 
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