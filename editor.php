<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <script src="https://rawgit.com/ArthurClemens/Javascript-Undo-Manager/master/lib/undomanager.js"></script>
    <base href="">
    <title>Vex</title>

    <link href="css/editor.css" rel="stylesheet">

</head>
<body>


<div id="vex-builder">
    <div id="vex-nav">NAV</div>
    <div id="vex-left-top-project-list">Project List
        <div class="drop">Place Here</div>
        <div class="undo-container">
            <input id="undo" class="undo-redo" type="button" value="undo" >
            <input id="redo" class="undo-redo" type="button" value="redo">
        </div>
    </div>
    <div id="vex-component">

        <ul id="drag-list-container">
            <li draggable="true" data-insert-html="<h1>HEADER H1</h1>"><i class="fa fa-header"></i>
                <p >Header</p></li>
            <li draggable="true"><img src="./img/empty-avatar.png">
                <p>Chart</p></li>
            <li draggable="true"><i class="fa fa-envelope"></i>
                <p>Contact</p></li>
        </ul>

    </div>

    <div id="vex-page">
        <div id="iframe-wapper" style="width:100%;height:100%">
            <div id="iframe-layer">
                <div id="select-box" style="display: none; pointer-events:none;">

                    <div id="wysiwyg-editor" style="pointer-events:auto;">
                        <ul id="bold-btn" href="" title="Bold"></ul>
                        <a id="bold-btn" href="" title="Bold"><i><strong>B</strong></i></a>
                        <a id="italic-btn" href="" title="Italic"><i>I</i></a>
                        <a id="underline-btn" href="" title="Underline"><u>u</u></a>
                        <a id="strike-btn" href="" title="Strikeout">
                            <del>S</del>
                        </a>
                        <a id="link-btn" href="" title="Create link"><strong>a</strong></a>
                    </div>

                    <div id="select-actions">
                        <a id="drag-btn" href="" title="Drag element"><i class="la la-arrows"></i></a>
                        <a id="parent-btn" href="" title="Select parent"><i class="la la-level-down la-rotate-180"></i></a>

                        <a id="up-btn" href="" title="Move element up"><i class="la la-arrow-up"></i></a>
                        <a id="down-btn" href="" title="Move element down"><i class="la la-arrow-down"></i></a>
                        <a id="clone-btn" href="" title="Clone element"><i class="la la-copy"></i></a>
                        <a id="delete-btn" href="" title="Remove element"><i class="la la-trash"></i></a>
                    </div>
                </div>
            </div>
            <iframe class="drop" style="width:100%;height:100%;" src="index.php"></iframe>
        </div>
    </div>
    <div id="vex-toolbar">Toolbar</div>
</div>

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


<script src="js/editor.js"></script>
<script src="lib/js/dragdrop.js"></script>
<script src="lib/js/undo_redo.js"></script>

</body>
</html>