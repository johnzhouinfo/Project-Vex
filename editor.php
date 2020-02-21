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

    <base href="">
    <title>Vex</title>

    <link href="css/editor.css" rel="stylesheet">

</head>
<body>


<div id="vex-builder">
    <div id="vex-nav">NAV</div>
    <div id="vex-left-top-project-list">Project List
        <div class="drop">Place Here</div>
    </div>
    <div id="vex-component">
        <table>
            <tr>
                <td>
                    <div class="component">
                        <img src="img/empty-avatar.png" alt="avatar"/>
                    </div>
                </td>
            </tr>
            <!--            <tr>-->
            <!--                <td>-->
            <!--                    <div class = "component">-->
            <!--                        <p>Item2</p>-->
            <!--                    </div>-->
            <!--                </td>-->
            <!--            </tr>-->
            <!--            <tr>-->
            <!--                <td>row 3</td>-->
            <!--            </tr>-->
            <!--            <tr>-->
            <!--                <td>row 4</td>-->
            <!--            </tr>-->
            <!--            <tr>-->
            <!--                <td>row 5</td>-->
            <!--            </tr>-->
            <!--            <tr>-->
            <!--                <td>row 6</td>-->
            <!--            </tr>-->
            <!--            <tr>-->
            <!--                <td>row 7</td>-->
            <!--            </tr>-->
            <!--            <tr>-->
            <!--                <td>row 8</td>-->
            <!--            </tr>-->
        </table>
    </div>

    <div id="vex-page">
        <iframe class="drop" style="width:100%;height:100%" src="index.php"></iframe>
    </div>
    <div id="vex-toolbar">Toolbar</div>
</div>

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script src="js/editor.js"></script>

<script>
    $(function () {
        $(".component").draggable({
            appendTo: "body",
            cursor: "move",
            helper: 'clone',
            revert: "true",

        });
        $(".drop, iframe html div span").droppable({
            tolerance: "intersect",
            accept: ".component",
            activeClass: "ui-state-default",
            hoverClass: "ui-state-hover",
            drop: function (event, ui) {
                //$(this).append($(ui.draggable).clone());
                $(ui.draggable).clone().insertAfter($(this));
            }
        });
    });

</script>
</body>
</html>