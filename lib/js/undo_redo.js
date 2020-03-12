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
    undoBtn.classList[undo_manager.hasUndo() ? 'remove' : 'add']('disabled');
    redoBtn.classList[undo_manager.hasRedo() ? 'remove' : 'add']('disabled');
}

// $("#drag-list-container li").on('dragstart', dragStartHandler);

// function dragStartHandler(event) {
//     // console.log("Drag Started");
//     // retrieve the html code in the tag
//     var insertingHTML = $(this).attr('data-insert-html');
//     event.originalEvent.dataTransfer.setData("text", insertingHTML);
// }

// $('.drop').load(function (){
//     var frameWindow = $(this).prop('contentWindow');
//     var checkDiv;
//     $(frameWindow.document).find('body,html').on('drop', function(event){
//         event.preventDefault();
//         console.log("dropping")
//         var textData = event.originalEvent.dataTransfer.getData('text');
//         checkDiv = $(textData);
//         // console.log(checkDiv);
//         // frameWindow.document.body.ondrop = afterdrop(frameWindow, checkDiv);
//     })
    
// })

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
}