<?php
session_start();
require_once "./lib/config.php";
$pageId = 0;
$componentResult = pg_query($link, "SELECT * FROM vex_component WHERE is_delete = false AND is_enable = true ORDER BY component_id");
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) {
    echo "<script>var isLoggined = true;</script>";
} else
    echo "<script>var isLoggined = false;</script>";
if (isset($_SESSION["id"])) {
    $userId = $_SESSION["id"];
    $projectResult = pg_query($link, "SELECT product_id, product_name, is_live FROM vex_product WHERE user_id = $userId AND is_delete = false ORDER BY create_time");
}
if (!$componentResult) {
    echo "An error occurred.\n";
    exit;
}

//Open project from the user_profile or admin_project_mngt URL with get request.
if (isset($_GET["id"])) {
    $pageId = $_GET["id"];
    if (isset($_SESSION["loggedin"])) {
        if (isset($_SESSION["admin"]) && isset($_SESSION["admin"]) === true) {
            $sql = "SELECT * from vex_product WHERE product_id = $pageId AND is_delete = false";
        } else {
            $sql = "SELECT * from vex_product WHERE product_id = $pageId AND user_id = $userId AND is_delete = false";
        }
        $loadPageResult = pg_query($link, $sql);

    } else {
        echo "<script>setTimeout(function() {
                      swal(\"Failed!\", \"You don't have permission!\", \"error\");
                    },100)</script>";
        $pageId = 0;
    }


}

pg_close($link);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">


    <link rel="stylesheet" href="lib/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="lib/css/styles.css">
    <link rel="stylesheet" href="lib/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="lib/css/Features-Clean.css">
    <link rel="stylesheet" href="lib/css/Footer-Basic.css">
    <link rel="stylesheet" href="lib/css/Highlight-Clean.css">
    <link rel="stylesheet" href="lib/css/Login-Form-Clean.css">
    <link rel="stylesheet" href="lib/css/Registration-Form-with-Photo.css">
    <link rel="stylesheet" href="lib/css/sweetalert.css">
    <link rel="stylesheet" href="css/common.css">
    <script src="https://rawgit.com/ArthurClemens/Javascript-Undo-Manager/master/lib/undomanager.js"></script>

    <base href="">
    <title>Vex</title>

    <link href="css/editor.css" rel="stylesheet">

</head>
<body>


<div id="vex-builder">
    <div id="vex-nav">
        <nav class="navbar navbar-light navbar-expand fixed-top text-left"
             style="background-color: #ffffff;height: 50px;">
            <div class="container-fluid" style="height: 50px;">
                <img id="home_emblem" style="width: 24px;height: 24px;" src="img/Vex_Three.gif" alt="vex_logo">
                <a class="navbar-brand" id="home_brand" href="index.php">&nbsp;Vex</a>
                <div class="collapse navbar-collapse" id="navcol-1">
                    <ul class="nav navbar-nav"></ul>
                </div>
                <!--                <div class="collapse navbar-collapse undo-container" style="position: relative;">-->
                <!--                    <input id="undo" class="undo-redo disable" value="undo" type="button">-->
                <!--                    <input id="redo" class="undo-redo disable" value="redo" type="button">-->
                <!--                    <input onclick="saveOrUpdate(event)" type="button" value="Save">-->
                <!--                </div>-->
                <ul class="nav navbar-nav">
                    <li class="nav-item" role="presentation">
                        <div id="login-btn-group" style="position: relative; height: 40px; display:
            <?php if (isset($_SESSION["id"])) {
                            echo "none;";
                        } else {
                            echo "flex";
                        }
                        ?>">
                            <button class="btn btn-primary" id="home_login" type="button" data-toggle="modal"
                                    data-target="#login_modal">Login
                            </button>
                            <ul class="nav navbar-nav">
                                <li class="nav-item" role="presentation"><a class="nav-link text-primary" id="register"
                                                                            href="">Register</a></li>
                            </ul>
                        </div>
                        <div id="user-btn-group" style="position: relative; height: 40px; display:
                        <?php if (!isset($_SESSION["id"])) {
                            echo "none;";
                        } else {
                            echo "";
                        }
                        ?>
                                ">
                            <a data-toggle="dropdown" aria-expanded="false" class="dropdown-toggle nav-link"
                               style="padding-top: 0px">
                                Hi! <span id="username-text" class="UserInfo-avatar">
                        <?php
                        if (isset($_SESSION["name"]))
                            echo $_SESSION["name"];
                        else
                            echo "USER";
                        ?>
                    </span>
                                <img style="border-radius: 50%;" class="avatar-img" id="user-avatar" width="40"
                                     height="40"
                                     src="<?php
                                     if (isset($_SESSION["loggedin"])) {
                                         echo($_SESSION["icon"] == null ? "img/empty-avatar.png" : $_SESSION["icon"]);
                                     }
                                     ?>" alt="">
                            </a>
                            <div role="menu" class="dropdown-menu shadow dropdown-menu-right animated--grow-in">
                                <a id="manage-btn" role="presentation" class="dropdown-item" href="#"
                                   style="display: <?php
                                   if (isset($_SESSION["admin"]) && $_SESSION["admin"] == true)
                                       echo "";
                                   else
                                       echo "none";
                                   ?>">
                                    <i class="fa fa-wrench fa-sm fa-fw mr-2 text-gray-400"></i>
                                     Web Manage
                                </a>
                                <a id="profile-btn" role="presentation" class="dropdown-item" href="#">
                                    <i class="fa fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                     Profile
                                </a>
                                <a id="project-btn" role="presentation" class="dropdown-item" href="#">
                                    <i class="fa fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                     Projects
                                </a>
                                <div class="dropdown-divider"></div>
                                <a id="logout-btn" role="presentation" class="dropdown-item" href="#">
                                    <i class="fa fa-sign-out fa-sm fa-fw mr-2 text-gray-400"></i>
                                     Logout
                                </a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>

    <div class="search"
         style="position: absolute; background-color: #f7f9ff; height: 40px; width:300px; padding: 4px; border-top: 1px solid #ddd;">
        Project
        <button class="btn btn-outline-dark border rounded-0" data-toggle="modal" data-target="#new_page_modal"
                type="button"
                style="font-size: 10px; margin-left: 80px;" title="New Project">
            <i class="fa fa-plus" style="font-size: 10px;"></i>
        </button>
    </div>
    <div id="vex-left-top-project-list">


        <div>
            <ul id="product-list">
                <?php
                if (isset($_SESSION["id"])) {
                    while ($row = pg_fetch_array($projectResult)) {
                        $productName = $row['product_name'];
                        $productId = $row['product_id'];
                        $isLive = $row['is_live'] == "t" ? "Checked" : "";
                        $isLiveStatus = $row['is_live'] == "t" ? "" : "none";
                        $code = "<li style=\"padding: 5px 10px;margin: 5px 10px; border-style: solid; border-width: 1px; border-radius: 5px\">
                    <img src =\"img/file.svg\" alt=\"page\" width=\"19px\" style=\"padding-bottom: 2px\">
                    <a id='product-id-$productId'  class='product-list product-list-name' onclick='loadPage(event)' productId='$productId' >$productName</a>
                    <div class=\"product-option\" style=\"float: right\">
                        <label class=\"switch\" style=\"margin-top: 2px;\" title='Live/Offline Page'>
                            <input class='product-list-is-live' onChange='changeLiveStatus(event)'  productId='$productId' type='checkbox' $isLive>
                            <span class=\"slider round\"><img src='img/LIVE.svg' class='live-text' style='display: $isLiveStatus'></span>
                        </label>
                        <a href=\"#\" class=\"\" data-toggle=\"dropdown\" style=\"margin: 4px\"><button class=\"product-list-btn\" style=\"width: 20px\"><strong>&#8942;</strong></button></a>
                        <div class=\"dropdown-menu\">
                            <a role=\"presentation\" class='dropdown-item product-list-share product-list-btn' onclick='shareURL($productId)'>
                                <i class=\"fa fa-link\"></i>
                                 Share URL
                            </a>
                            <a role=\"presentation\" class='dropdown-item product-list-change-name product-list-btn' onclick='initChangeName(event)' product-name='$productName' product-id='$productId' data-toggle=\"modal\" data-target = \"#change_name_modal\">
                                <i class=\"fa fa-pencil\"></i>
                                 Rename
                            </a>
                            <a role=\"presentation\" class='dropdown-item product-list-delete product-list-btn' onclick='deleteProduct(event)' productId='$productId'>
                                <i class=\"fa fa-trash\" style=\"color: red\"></i>
                                 Delete
                            </a>
                        </div>
                </li>";
                        echo $code;

                    }
                }
                ?>
            </ul>
        </div>
    </div>
    <div style="position: absolute; background-color: #f7f9ff; top: 350px; width: 300px; padding: 7px; height: 40px; border-right: 1px solid #ddd;">
        Components
    </div>
    <div id="vex-component">
        <div class="search">
            <input id="component-search" class="form-control form-control-sm component-search"
                   placeholder="Search components" type="text">
            <button id="clear-component-search-input" class="clear-backspace">
                <i class="fa fa-close"></i>
            </button>
        </div>
        <ul id="drag-list-container">
            <?php
            while ($row = pg_fetch_array($componentResult)) {
                $name = $row['component_name'];
                $code = str_replace("\"", "'", $row['code']);
                $icon = $row['icon'] == null ? "./img/empty-avatar.png" : $row['icon'];
                echo " <li draggable=\"true\" data-insert-html=\"$code\"><img src=\"$icon\"></i>
                <p>$name</p></li>";
            }
            ?>
        </ul>
    </div>

    <div id="vex-nav-tool">
        <div class="container">
            <div class="row">
                <div class="col-md-4 text-center">
                    <button class="btn btn-light undo-redo disable" title="Undo" id="undo"
                            style="background-color: white">
                        <i class="fa fa-undo"></i>
                    </button>

                    <button class="btn btn-light undo-redo disable" title="Redo" id="redo"
                            style="background-color: white">
                        <i class="fa fa-repeat"></i>
                    </button>

                </div>
                <div class="col-md-4 text-center">
                    <button class="btn btn-light " title="Preview" id="preview-btn" style="background-color: white"
                            disabled>
                        <i class="fa fa-eye"></i>
                    </button>
                    <button class="btn btn-light " onclick="saveOrUpdate(event)" title="Save" id="save-btn"
                            style="background-color: white" disabled>
                        <i class="fa fa-save"></i>
                    </button>

                    <button class="btn btn-light " title="Download" id="download-btn" style="background-color: white"
                            disabled>
                        <i class="fa fa-download"></i>
                    </button>

                </div>
                <div class="col-md-4 text-center">
                    <button class="btn btn-light" title="Tutorial" id="tut-btn" style="background-color: white">
                        <i class="fa fa-question-circle-o"></i>
                    </button>
                    <button class="btn btn-light" title="Get Support" id="help-btn" style="background-color: white"
                    >
                        <img class="icon-help" src="img/help-icon.png" width="13.7" height="16">
                    </button>
                    <button style="display: none" data-toggle="modal" id="help-hidden-btn"
                            data-target="#get_support_modal"></button>
                </div>
            </div>
        </div>
    </div>
    <div id="vex-page">
        <div id="iframe-wapper" style="width:100%;height:100%">
            <div id="iframe-layer">
                <div id="select-box" style="display: none; pointer-events:none;">

                    <div id="select-editor" style="pointer-events:auto; display: none;">
                        <a id="bold-btn" draggable="false" href="" title="Bold"><i><strong>B</strong></i></a>
                        <a id="italic-btn" draggable="false" href="" title="Italic"><i>I</i></a>
                        <a id="underline-btn" draggable="false" href="" title="Underline"><u>u</u></a>
                    </div>

                    <div id="select-actions" style="pointer-events:auto;">

                        <a id="parent-btn" draggable="false" href="" title="Select parent"><i
                                    class="fa fa-level-up"></i></a>
                        <a id="clone-btn" draggable="false" href="" title="Clone element"><i class="fa fa-copy"></i></a>
                        <a id="delete-btn" draggable="false" href="" title="Remove element"><i class="fa fa-trash"></i></a>
                    </div>

                    <div id="select-tag-name">
                        <span id="tag-name">&lt;tag&gt;</span>
                    </div>
                </div>
            </div>
            <?php
            if (isset($_GET["id"])) {
                if (pg_num_rows($loadPageResult) == 0) {
                    if (isset($_SESSION["admin"])) {
                        echo "<script>setTimeout(function() {swal('Failed!', 'Page doesn\'t exist!', 'error');},100)</script>";
                        echo "<iframe class=\"drop\" style=\"width:100%;height:100%;\" src=\"page.php?id=0\" product-id=\"\"></iframe>";
                    } else {
                        echo "<script>setTimeout(function() {swal('Failed!', 'You don\'t have permission!', 'error');},100)</script>";
                        echo "<iframe class=\"drop\" style=\"width:100%;height:100%;\" src=\"page.php?id=0\" product-id=\"\"></iframe>";
                    }
                } else {
                    $pageId = $_GET["id"];
                    echo "<iframe class=\"drop\" style=\"width:100%;height:100%;\" src=\"page.php?id=$pageId\" product-id=\"$pageId\"></iframe>";
                }
            } else {
                echo "<iframe class=\"drop\" style=\"width:100%;height:100%;\" src=\"page.php?id=0\" product-id=\"\"></iframe>";
            }

            ?>

        </div>
    </div>


    <div id="vex-toolbar">
        <div>
            <ul class="nav nav-tabs">
                <li class="nav-item tab-class">

                    <a class="nav-link tab-item-class active" role="tab" data-toggle="tab" href="#tab-1"><i
                                class="fa fa-cube"></i><br>Content</a>
                </li>
                <li class="nav-item tab-class"><a class="nav-link tab-item-class" role="tab" data-toggle="tab"
                                                  href="#tab-2"><i class="fa fa-window-maximize"></i><br>Style</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" role="tabpanel" id="tab-1">
                    <div role="tablist" id="accordion-1">
                        <div class="card default-tab" id="general-tab">
                            <div class="card-header" role="tab">
                                <h5 class="mb-0"><a data-toggle="collapse" aria-expanded="true"
                                                    aria-controls="accordion-1 .item-1" href="div#accordion-1 .item-1">General</a>
                                </h5>
                            </div>
                            <div class="collapse show item-1" role="tabpanel" data-parent="#accordion-1">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <form class="form-horizontal">
                                            <div class="form-group"><label
                                                        class="text-nowrap d-inline col-sm-2">Id</label>
                                                <div class="col-sm-10"><input class="form-control element-attribute"
                                                                              type="text" id="attribute-id"
                                                                              attr-data-type="id"></div>
                                            </div>
                                        </form>
                                        <form class="form-horizontal">
                                            <div class="form-group"><label
                                                        class="text-nowrap d-inline col-sm-2">Class</label>
                                                <div class="col-sm-10"><input class="form-control element-attribute"
                                                                              type="text" id="attribute-class"
                                                                              attr-data-type="class"></div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card default-hide-tab" id="button-tab">
                            <div class="card-header" role="tab">
                                <h5 class="mb-0"><a data-toggle="collapse" aria-expanded="false"
                                                    aria-controls="accordion-1 .item-2" href="div#accordion-1 .item-2">Button</a>
                                </h5>
                            </div>
                            <div class="collapse item-2" role="tabpanel" data-parent="#accordion-1">
                                <div class="card-body">
                                    <form class="form-horizontal">
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Name </label>
                                            <div class="col-sm-10"><input class="form-control element-attribute"
                                                                          type="text" id="attribute-button-name"
                                                                          attr-data-type="name"></div>
                                        </div>
                                    </form>
                                    <form class="form-horizontal">
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Text</label>
                                            <div class="col-sm-10"><input class="form-control element-attribute"
                                                                          type="text" id="attribute-button-text"
                                                                          attr-data-type="text"></div>
                                        </div>
                                    </form>
                                    <form class="form-horizontal">
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Type</label>
                                            <div class="col-sm-10"><select class="form-control element-attribute"
                                                                           id="attribute-button-type"
                                                                           style="padding: 6px 15px;"
                                                                           attr-data-type="type">
                                                    <option value="" selected="">Default</option>
                                                    <option value="button">Button</option>
                                                    <option value="reset">Reset</option>
                                                    <option value="submit">Submit</option>
                                                </select></div>
                                        </div>
                                    </form>
                                    <form class="form-horizontal">
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Disabled<br><label
                                                        class="switch">
                                                    <input id="attribute-button-disabled" class="element-attribute"
                                                           type="checkbox" attr-data-type="disabled">
                                                    <span class="slider round"></span>
                                                </label></label></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card default-hide-tab" id="link-tab">
                            <div class="card-header" role="tab">
                                <h5 class="mb-0"><a data-toggle="collapse" aria-expanded="false"
                                                    aria-controls="accordion-1 .item-3"
                                                    href="div#accordion-1 .item-3">Link</a>
                                </h5>
                            </div>
                            <div class="collapse item-3" role="tabpanel" data-parent="#accordion-1">
                                <div class="card-body">
                                    <form class="form-horizontal">
                                        <div class="form-group"><label class="text-nowrap col-sm-2">URL</label>
                                            <div class="col-sm-10"><input class="form-control element-attribute"
                                                                          type="text" id="attribute-a-href"
                                                                          attr-data-type="href"></div>
                                        </div>
                                    </form>
                                    <form class="form-horizontal">
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Target</label>
                                            <div class="col-sm-10"><input class="form-control element-attribute"
                                                                          type="text" id="attribute-a-target"
                                                                          attr-data-type="target"></div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card default-hide-tab" id="heading-tab">
                            <div class="card-header" role="tab">
                                <h5 class="mb-0"><a data-toggle="collapse" aria-expanded="false"
                                                    aria-controls="accordion-1 .item-4" href="div#accordion-1 .item-4">Heading</a>
                                </h5>
                            </div>
                            <div class="collapse item-4" role="tabpanel" data-parent="#accordion-1">
                                <div class="card-body">
                                    <form class="form-horizontal">
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Size</label>
                                            <div class="col-sm-10"><select class="form-control element-attribute"
                                                                           id="attribute-size"
                                                                           attr-data-type="heading-size">
                                                    <option value="1" selected="">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                </select></div>
                                        </div>
                                    </form>
                                    <form>
                                        <div class="field"></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card default-hide-tab" id="video-tab">
                            <div class="card-header" role="tab">
                                <h5 class="mb-0"><a data-toggle="collapse" aria-expanded="false"
                                                    aria-controls="accordion-1 .item-5"
                                                    href="div#accordion-1 .item-5">Video</a>
                                </h5>
                            </div>
                            <div class="collapse item-5" role="tabpanel" data-parent="#accordion-1">
                                <div class="card-body">
                                    <form class="form-horizontal">
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Src</label>
                                            <div class="col-sm-10"><input class="form-control element-attribute"
                                                                          type="text" id="attribute-video-src"
                                                                          attr-data-type="src">
                                            </div>
                                        </div>
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Width</label>
                                            <div class="col-sm-10"><input class="form-control element-attribute"
                                                                          type="text" id="attribute-video-width"
                                                                          attr-data-type="width"></div>
                                        </div>
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Height</label>
                                            <div class="col-sm-10"><input class="form-control element-attribute"
                                                                          type="text" id="attribute-video-height"
                                                                          attr-data-type="height"></div>
                                        </div>
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Muted<br><label
                                                        class="switch">
                                                    <input id="attribute-video-muted" class="element-attribute"
                                                           type="checkbox" attr-data-type="muted">
                                                    <span class="slider round"></span>
                                                </label></label></div>
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Loop<br><label
                                                        class="switch">
                                                    <input id="attribute-video-loop" class="element-attribute"
                                                           type="checkbox" attr-data-type="loop">
                                                    <span class="slider round"></span>
                                                </label></label></div>
                                        <div class="form-group"><label
                                                    class="text-nowrap col-sm-2">AutoPlay&nbsp;<br><label
                                                        class="switch">
                                                    <input id="attribute-video-autoplay" class="element-attribute"
                                                           type="checkbox" attr-data-type="autoplay">
                                                    <span class="slider round"></span>
                                                </label></label></div>
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Controls<br><label
                                                        class="switch">
                                                    <input id="attribute-video-controls" class="element-attribute"
                                                           type="checkbox" attr-data-type="controls">
                                                    <span class="slider round"></span>
                                                </label></label></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card default-hide-tab" id="image-tab">
                            <div class="card-header" role="tab">
                                <h5 class="mb-0"><a data-toggle="collapse" aria-expanded="false"
                                                    aria-controls="accordion-1 .item-6"
                                                    href="div#accordion-1 .item-6">Image</a>
                                </h5>
                            </div>
                            <div class="collapse item-6" role="tabpanel" data-parent="#accordion-1">
                                <div class="card-body">
                                    <form class="form-horizontal">
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Image</label>
                                            <div class="col-sm-10"><input class="form-control element-attribute"
                                                                          type="text" id="attribute-img-src"
                                                                          attr-data-type="src"><input type="file"
                                                                                                      class="upload-btn"
                                                                                                      accept="image/*"
                                                                                                      data-type="src"
                                                                                                      attr-type="attribute">
                                            </div>
                                        </div>
                                    </form>
                                    <form class="form-horizontal">
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Width</label>
                                            <div class="col-sm-10"><input class="form-control element-attribute"
                                                                          type="text" id="attribute-img-width"
                                                                          attr-data-type="width"></div>
                                        </div>
                                    </form>
                                    <form class="form-horizontal">
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Height</label>
                                            <div class="col-sm-10"><input class="form-control element-attribute"
                                                                          type="text" id="attribute-img-height"
                                                                          attr-data-type="height"></div>
                                        </div>
                                    </form>
                                    <form class="form-horizontal">
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Alt</label>
                                            <div class="col-sm-10"><input class="form-control element-attribute"
                                                                          type="text" id="attribute-img-alt"
                                                                          attr-data-type="alt"></div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card default-hide-tab" id="form-tab">
                            <div class="card-header" role="tab">
                                <h5 class="mb-0"><a data-toggle="collapse" aria-expanded="false"
                                                    aria-controls="accordion-1 .item-7"
                                                    href="div#accordion-1 .item-7">Form</a>
                                </h5>
                            </div>
                            <div class="collapse item-7" role="tabpanel" data-parent="#accordion-1">
                                <div class="card-body">
                                    <form class="form-horizontal">
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Action</label>
                                            <div class="col-sm-10"><input class="form-control element-attribute"
                                                                          type="text" id="attribute-form-action"
                                                                          attr-data-type="action"></div>
                                        </div>
                                    </form>
                                    <form class="form-horizontal">
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Method</label>
                                            <div class="col-sm-10"><input class="form-control element-attribute"
                                                                          type="text" id="attribute-form-method"
                                                                          attr-data-type="method"></div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card default-hide-tab" id="select-tab">
                            <div class="card-header" role="tab">
                                <h5 class="mb-0"><a data-toggle="collapse" aria-expanded="false"
                                                    aria-controls="accordion-1 .item-8" href="div#accordion-1 .item-8">Select</a>
                                </h5>
                            </div>
                            <div class="collapse item-8" role="tabpanel" data-parent="#accordion-1">
                                <div class="card-body">
                                    <div id="select-option"></div>
                                    <br>
                                    <form class="form-horizontal">
                                        <div class="form-group">
                                            <button class="btn btn-primary" id="select-add-btn" type="button">+ Add
                                                Option
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card default-hide-tab" id="input-tab">
                            <div class="card-header" role="tab">
                                <h5 class="mb-0"><a data-toggle="collapse" aria-expanded="false"
                                                    aria-controls="accordion-1 .item-9"
                                                    href="div#accordion-1 .item-9">Input</a>
                                </h5>
                            </div>
                            <div class="collapse item-9" role="tabpanel" data-parent="#accordion-1">
                                <div class="card-body">
                                    <form class="form-horizontal">
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Type</label>
                                            <div class="col-sm-10">
                                                <form>
                                                    <div class="field"><select class="form-control element-attribute"
                                                                               id="attribute-input-type"
                                                                               attr-data-type="type">
                                                            <option value=""></option>
                                                            <option value="text">Text</option>
                                                            <option value="radio">Radio</option>
                                                            <option value="checkbox">Checkbox</option>
                                                            <option value="button">Button</option>
                                                            <option value="color">Colour</option>
                                                            <option value="date">Date</option>
                                                            <option value="email">Email</option>
                                                            <option value="password">Password</option>
                                                            <option value="month">Month</option>
                                                            <option value="number">Number</option>
                                                        </select></div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Name </label>
                                            <div class="col-sm-10"><input class="form-control element-attribute"
                                                                          type="text" id="attribute-input-name"
                                                                          attr-data-type="name"></div>
                                        </div>
                                    </form>
                                    <form class="form-horizontal">
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Value</label>
                                            <div class="col-sm-10"><input class="form-control element-attribute"
                                                                          type="text" id="attribute-input-value"
                                                                          attr-data-type="value"></div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card default-hide-tab" id="table-tab">
                            <div class="card-header" role="tab">
                                <h5 class="mb-0"><a data-toggle="collapse" aria-expanded="false"
                                                    aria-controls="accordion-1 .item-10"
                                                    href="div#accordion-1 .item-10">Table</a></h5>
                            </div>
                            <div class="collapse item-10" role="tabpanel" data-parent="#accordion-1">
                                <div class="card-body">
                                    <form class="form-horizontal">
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Row</label>
                                            <div class="col-sm-10"><input class="form-control" type="text"
                                                                          id="table-row"></div>
                                        </div>
                                    </form>
                                    <form class="form-horizontal">
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Col</label>
                                            <div class="col-sm-10"><input class="form-control" type="text"
                                                                          id="table-col"><br>
                                                <button class="btn btn-primary" id="table-resize-btn" type="button">
                                                    Resize
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" role="tabpanel" id="tab-2">
                    <div role="tablist" id="accordion-2">
                        <div class="card default-tab">
                            <div class="card-header" role="tab">
                                <h5 class="mb-0"><a data-toggle="collapse" aria-expanded="true"
                                                    aria-controls="accordion-2 .item-1" href="div#accordion-2 .item-1">Display</a>
                                </h5>
                            </div>
                            <div class="collapse show item-1" role="tabpanel" data-parent="#accordion-2">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <form class="form-horizontal">
                                            <div class="form-group"><label
                                                        class="text-nowrap d-inline col-sm-2">Display</label>
                                                <div class="col-sm-10"><select class="form-control element-style"
                                                                               id="style-display"
                                                                               style-data-type="display">
                                                        <option value="" selected="">Default</option>
                                                        <option value="block">Block</option>
                                                        <option value="inline">Inline</option>
                                                        <option value="inline-block">Inline Block</option>
                                                        <option value="none">None</option>
                                                    </select></div>
                                            </div>
                                            <div class="form-group"><label
                                                        class="text-nowrap d-inline col-sm-2">Left</label>
                                                <div class="col-sm-10"><input class="form-control element-style"
                                                                              type="text" id="style-left"
                                                                              style-data-type="left"></div>
                                            </div>
                                            <div class="form-group"><label
                                                        class="text-nowrap d-inline col-sm-2">Top</label>
                                                <div class="col-sm-10"><input class="form-control element-style"
                                                                              type="text" id="style-top"
                                                                              style-data-type="top"></div>
                                            </div>
                                            <div class="form-group"><label
                                                        class="text-nowrap d-inline col-sm-2">Float</label>
                                                <div class="col-sm-10"><select class="form-control element-style"
                                                                               id="style-float" style-data-type="float">
                                                        <option value="none">None</option>
                                                        <option value="left">Left</option>
                                                        <option value="right">Right</option>
                                                    </select></div>
                                            </div>
                                        </form>
                                        <form class="form-horizontal">
                                            <div class="form-group"><label
                                                        class="text-nowrap d-inline col-sm-2">Position</label>
                                                <div class="col-sm-10"><select class="form-control element-style"
                                                                               id="style-position"
                                                                               style-data-type="position">
                                                        <option value="" selected="">Default</option>
                                                        <option value="static">Static</option>
                                                        <option value="fixed">Fixed</option>
                                                        <option value="relative">Relative</option>
                                                        <option value="absolute">Absolute</option>
                                                    </select></div>
                                            </div>
                                            <div class="form-group"><label
                                                        class="text-nowrap d-inline col-sm-2">Right</label>
                                                <div class="col-sm-10"><input class="form-control element-style"
                                                                              type="text" id="style-right"
                                                                              style-data-type="right"></div>
                                            </div>
                                            <div class="form-group"><label
                                                        class="text-nowrap d-inline col-sm-2">Bottom</label>
                                                <div class="col-sm-10"><input class="form-control element-style"
                                                                              type="text" id="style-bottom"
                                                                              style-data-type="bottom"></div>
                                            </div>
                                        </form>
                                    </div>
                                    <form class="form-horizontal">
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Opacity</label>
                                            <div class="col-sm-10"><input class="form-control-range element-style"
                                                                          type="range" id="style-opacity" step="0.1"
                                                                          min="0" max="1" value="1"
                                                                          style-data-type="opacity"></div>
                                        </div>
                                    </form>
                                    <div class="d-flex">
                                        <form class="form-horizontal">
                                            <div class="form-group"><label class="text-nowrap d-inline col-sm-2">BackGround
                                                    Colour</label>
                                                <div class="col-sm-10"><input type="color" id="style-background-color"
                                                                              class="element-style" value="#ffffff"
                                                                              style-data-type="background-color"></div>
                                            </div>
                                        </form>
                                        <form class="form-horizontal">
                                            <div class="form-group"><label class="text-nowrap d-inline col-sm-2">Text
                                                    Colour</label>
                                                <div class="col-sm-10"><input type="color" id="style-color"
                                                                              class="element-style"
                                                                              style-data-type="color"></div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card default-tab">
                            <div class="card-header" role="tab">
                                <h5 class="mb-0"><a data-toggle="collapse" aria-expanded="false"
                                                    aria-controls="accordion-2 .item-2" href="div#accordion-2 .item-2">Typography</a>
                                </h5>
                            </div>
                            <div class="collapse item-2" role="tabpanel" data-parent="#accordion-2">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <form class="form-horizontal">
                                            <div class="form-group"><label class="text-nowrap d-inline col-sm-2">Font
                                                    family</label>
                                                <div class="col-sm-10"><select class="form-control element-style"
                                                                               id="style-font-family"
                                                                               style-data-type="font-family">
                                                        <option value="">Default</option>
                                                        <option value="Arial, Helvetica, sans-serif">Arial</option>
                                                        <option value="Lucida Sans Unicode">Lucida Grande</option>
                                                        <option value="Palatino Linotype">Palatino Linotype</option>
                                                        <option value="times new roman">Times New Roman</option>
                                                        <option value="Georgia, serif">Georgia, serif</option>
                                                        <option value="Tahoma, Geneva, sans-serif">Tahoma</option>
                                                        <option value="Comic Sans MS">Comic Sans</option>
                                                        <option value="Verdana, Geneva, sans-serif">Verdana</option>
                                                        <option value="Impact, Charcoal, sans-serif">Impact</option>
                                                        <option value="&quot;Arial Black&quot;, Gadget, sands-serif">
                                                            Arial Black
                                                        </option>
                                                        <option value="&quot;Trebuchet MS&quot;, Helvetica, sans-serif">
                                                            Trebuchet
                                                        </option>
                                                        <option value="&quot;Brush Script MT&quot;, sans-serif">Brush
                                                            Script
                                                        </option>
                                                    </select></div>
                                            </div>
                                            <div class="form-group"><label class="text-nowrap d-inline col-sm-2">Line
                                                    height</label>
                                                <div class="col-sm-10"><input class="form-control element-style"
                                                                              type="text" id="style-line-height"
                                                                              style-data-type="line-height"></div>
                                            </div>
                                            <div class="form-group"><label class="text-nowrap col-sm-2">Text
                                                    align</label>
                                                <div class="col-sm-10"><select class="form-control element-style"
                                                                               id="style-text-align"
                                                                               style-data-type="text-align">
                                                        <option value="">None</option>
                                                        <option value="left">Left</option>
                                                        <option value="center">Centre</option>
                                                        <option value="right">Right</option>
                                                        <option value="justify">Justify</option>
                                                    </select></div>
                                            </div>
                                            <div class="form-group"><label class="text-nowrap d-inline col-sm-2">Decoration
                                                    style</label>
                                                <div class="col-sm-10"><select class="form-control element-style"
                                                                               id="style-text-decoration-style"
                                                                               style-data-type="text-decoration-style">
                                                        <option value="">Default</option>
                                                        <option value="solid">Solid</option>
                                                        <option value="wavy">Wavy</option>
                                                        <option value="dotted">Dotted</option>
                                                        <option value="dashed">Dashed</option>
                                                        <option value="double">Double</option>
                                                    </select></div>
                                            </div>
                                        </form>
                                        <form class="form-horizontal">
                                            <div class="form-group"><label class="text-nowrap d-inline col-sm-2">Font
                                                    weight</label>
                                                <div class="col-sm-10"><select class="form-control element-style"
                                                                               id="style-font-weight"
                                                                               style-data-type="font-weight">
                                                        <option value="" selected="">Default</option>
                                                        <option value="100">Thin</option>
                                                        <option value="200">Extra-Light</option>
                                                        <option value="300">Light</option>
                                                        <option value="400">Normal</option>
                                                        <option value="500">Medium</option>
                                                        <option value="600">Semi-Bold</option>
                                                        <option value="700">Bold</option>
                                                        <option value="800">Extra-Bold</option>
                                                        <option value="900">Ultra-Bold</option>
                                                    </select></div>
                                            </div>
                                            <div class="form-group"><label class="text-nowrap d-inline col-sm-2">Letter
                                                    spacing</label>
                                                <div class="col-sm-10"><input class="form-control element-style"
                                                                              type="text" id="style-letter-spacing"
                                                                              style-data-type="letter-spacing"></div>
                                            </div>
                                            <div class="form-group"><label class="text-nowrap col-sm-2">Text
                                                    decoration</label>
                                                <div class="col-sm-10"><select class="form-control element-style"
                                                                               id="style-text-decoration-line"
                                                                               style-data-type="text-decoration-line">
                                                        <option value="">None</option>
                                                        <option value="underline">Underline</option>
                                                        <option value="overline">Overline</option>
                                                        <option value="line-through">Line Through</option>
                                                        <option value="underline overline">Underline Overline</option>
                                                    </select></div>
                                            </div>
                                            <div class="form-group"><label class="text-nowrap col-sm-2">Decoration
                                                    colour</label>
                                                <div class="col-sm-10"><input type="color"
                                                                              id="style-text-decoration-color"
                                                                              class="element-style" value="#ffffff"
                                                                              style-data-type="text-decoration-color">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card default-tab">
                            <div class="card-header" role="tab">
                                <h5 class="mb-0"><a data-toggle="collapse" aria-expanded="false"
                                                    aria-controls="accordion-2 .item-3"
                                                    href="div#accordion-2 .item-3">Size</a>
                                </h5>
                            </div>
                            <div class="collapse item-3" role="tabpanel" data-parent="#accordion-2">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <form class="form-horizontal">
                                            <div class="form-group"><label class="text-nowrap col-sm-2">Width</label>
                                                <div class="col-sm-10">
                                                    <div class="d-flex"><input class="form-control element-style"
                                                                               type="text" id="style-width"
                                                                               style="height: 31px;width: 300%;"
                                                                               style-data-type="width"></div>
                                                </div>
                                            </div>
                                            <div class="form-group"><label class="text-nowrap col-sm-2">Min
                                                    Width</label>
                                                <div class="col-sm-10">
                                                    <div class="d-flex"><input class="form-control element-style"
                                                                               type="text" id="style-min-width"
                                                                               style="height: 31px;width: 300%;"
                                                                               style-data-type="min-width"></div>
                                                </div>
                                            </div>
                                            <div class="form-group"><label class="text-nowrap col-sm-2">Max
                                                    Width</label>
                                                <div class="col-sm-10">
                                                    <div class="d-flex"><input class="form-control element-style"
                                                                               type="text" id="style-max-width"
                                                                               style="height: 31px;width: 300%;"
                                                                               style-data-type="max-width"></div>
                                                </div>
                                            </div>
                                        </form>
                                        <form class="form-horizontal">
                                            <div class="form-group"><label class="text-nowrap col-sm-2">Height</label>
                                                <div class="col-sm-10">
                                                    <div class="d-flex"><input class="form-control element-style"
                                                                               type="text" id="style-height"
                                                                               style="height: 31px;width: 300%;"
                                                                               style-data-type="height"></div>
                                                </div>
                                            </div>
                                            <div class="form-group"><label class="text-nowrap col-sm-2">Min
                                                    Height</label>
                                                <div class="col-sm-10">
                                                    <div class="d-flex"><input class="form-control element-style"
                                                                               type="text" id="style-min-height"
                                                                               style="height: 31px;width: 300%;"
                                                                               style-data-type="min-height"></div>
                                                </div>
                                            </div>
                                            <div class="form-group"><label class="text-nowrap col-sm-2">Max
                                                    Height</label>
                                                <div class="col-sm-10">
                                                    <div class="d-flex"><input class="form-control element-style"
                                                                               type="text" id="style-max-height"
                                                                               style="height: 31px;width: 300%;"
                                                                               style-data-type="max-height"></div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card default-tab">
                            <div class="card-header" role="tab">
                                <h5 class="mb-0"><a data-toggle="collapse" aria-expanded="false"
                                                    aria-controls="accordion-2 .item-4" href="div#accordion-2 .item-4">Margin</a>
                                </h5>
                            </div>
                            <div class="collapse item-4" role="tabpanel" data-parent="#accordion-2">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <form class="form-horizontal">
                                            <div class="form-group"><label class="text-nowrap col-sm-2">Top</label>
                                                <div class="col-sm-10">
                                                    <div class="d-flex"><input class="form-control element-style"
                                                                               type="text" id="style-margin-top"
                                                                               style="height: 31px;width: 300%;"
                                                                               style-data-type="margin-top"></div>
                                                </div>
                                            </div>
                                            <div class="form-group"><label class="text-nowrap col-sm-2">Bottom</label>
                                                <div class="col-sm-10">
                                                    <div class="d-flex"><input class="form-control element-style"
                                                                               type="text" id="style-margin-bottom"
                                                                               style="height: 31px;width: 300%;"
                                                                               style-data-type="margin-bottom"></div>
                                                </div>
                                            </div>
                                        </form>
                                        <form class="form-horizontal">
                                            <div class="form-group"><label class="text-nowrap col-sm-2">Right</label>
                                                <div class="col-sm-10">
                                                    <div class="d-flex"><input class="form-control element-style"
                                                                               type="text" id="style-margin-right"
                                                                               style="height: 31px;width: 300%;"
                                                                               style-data-type="margin-right"></div>
                                                </div>
                                            </div>
                                            <div class="form-group"><label class="text-nowrap col-sm-2">Left</label>
                                                <div class="col-sm-10">
                                                    <div class="d-flex"><input class="form-control element-style"
                                                                               type="text" id="style-margin-left"
                                                                               style="height: 31px;width: 300%;"
                                                                               style-data-type="margin-left"></div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card default-tab">
                            <div class="card-header" role="tab">
                                <h5 class="mb-0"><a data-toggle="collapse" aria-expanded="false"
                                                    aria-controls="accordion-2 .item-5" href="div#accordion-2 .item-5">Padding</a>
                                </h5>
                            </div>
                            <div class="collapse item-5" role="tabpanel" data-parent="#accordion-2">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <form class="form-horizontal">
                                            <div class="form-group"><label class="text-nowrap col-sm-2">Top</label>
                                                <div class="col-sm-10">
                                                    <div class="d-flex"><input class="form-control element-style"
                                                                               type="text" id="style-padding-top"
                                                                               style="height: 31px;width: 300%;"
                                                                               style-data-type="padding-top"></div>
                                                </div>
                                            </div>
                                            <div class="form-group"><label class="text-nowrap col-sm-2">Bottom</label>
                                                <div class="col-sm-10">
                                                    <div class="d-flex"><input class="form-control element-style"
                                                                               type="text" id="style-padding-bottom"
                                                                               style="height: 31px;width: 300%;"
                                                                               style-data-type="padding-bottom"></div>
                                                </div>
                                            </div>
                                        </form>
                                        <form class="form-horizontal">
                                            <div class="form-group"><label class="text-nowrap col-sm-2">Right</label>
                                                <div class="col-sm-10">
                                                    <div class="d-flex"><input class="form-control element-style"
                                                                               type="text" id="style-padding-right"
                                                                               style="height: 31px;width: 300%;"
                                                                               style-data-type="padding-right"></div>
                                                </div>
                                            </div>
                                            <div class="form-group"><label class="text-nowrap col-sm-2">Left</label>
                                                <div class="col-sm-10">
                                                    <div class="d-flex"><input class="form-control element-style"
                                                                               type="text" id="style-padding-left"
                                                                               style="height: 31px;width: 300%;"
                                                                               style-data-type="padding-left"></div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card default-tab">
                            <div class="card-header" role="tab">
                                <h5 class="mb-0"><a data-toggle="collapse" aria-expanded="false"
                                                    aria-controls="accordion-2 .item-6" href="div#accordion-2 .item-6">Border</a>
                                </h5>
                            </div>
                            <div class="collapse item-6" role="tabpanel" data-parent="#accordion-2">
                                <div class="card-body">
                                    <form class="form-horizontal">
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Style</label>
                                            <div class="col-sm-10"><select class="form-control element-style"
                                                                           id="style-border-style"
                                                                           style-data-type="border-style">
                                                    <option value="" selected="">Default</option>
                                                    <option value="solid">Solid</option>
                                                    <option value="dotted">Dotted</option>
                                                    <option value="dashed">Dashed</option>
                                                </select></div>
                                        </div>
                                    </form>
                                    <div class="d-flex">
                                        <form class="form-horizontal" action="#">
                                            <div class="form-group"><label class="text-nowrap col-sm-2">Width</label>
                                                <div class="col-sm-10">
                                                    <div class="d-flex"><input class="form-control element-style"
                                                                               type="text" id="style-border-width"
                                                                               style="height: 31px;width: 300%;"
                                                                               style-data-type="border-width"></div>
                                                </div>
                                            </div>
                                        </form>
                                        <form class="form-horizontal">
                                            <div class="form-group"><label
                                                        class="text-nowrap d-inline col-sm-2">Colour</label>
                                                <div class="col-sm-10"><input type="color" id="style-border-color"
                                                                              class="element-style" value="#ffffff"
                                                                              style-data-type="border-color"></div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card default-tab">
                            <div class="card-header" role="tab">
                                <h5 class="mb-0"><a data-toggle="collapse" aria-expanded="false"
                                                    aria-controls="accordion-2 .item-7" href="div#accordion-2 .item-7">Border
                                        radius</a></h5>
                            </div>
                            <div class="collapse item-7" role="tabpanel" data-parent="#accordion-2">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <form class="form-horizontal">
                                            <div class="form-group"><label class="text-nowrap col-sm-2">Top Left</label>
                                                <div class="col-sm-10">
                                                    <div class="d-flex"><input class="form-control element-style"
                                                                               type="text"
                                                                               id="style-border-top-left-radius"
                                                                               style="height: 31px;width: 300%;"
                                                                               style-data-type="border-top-left-radius">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group"><label class="text-nowrap col-sm-2">Bottom
                                                    Left</label>
                                                <div class="col-sm-10">
                                                    <div class="d-flex"><input class="form-control element-style"
                                                                               type="text"
                                                                               id="style-border-bottom-left-radius"
                                                                               style="height: 31px;width: 300%;"
                                                                               style-data-type="border-bottom-left-radius">
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <form class="form-horizontal">
                                            <div class="form-group"><label class="text-nowrap col-sm-2">Top
                                                    Right</label>
                                                <div class="col-sm-10">
                                                    <div class="d-flex"><input class="form-control element-style"
                                                                               type="text"
                                                                               id="style-border-top-right-radius"
                                                                               style="height: 31px;width: 300%;"
                                                                               style-data-type="border-top-right-radius">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group"><label class="text-nowrap col-sm-2">Bottom
                                                    Right</label>
                                                <div class="col-sm-10">
                                                    <div class="d-flex"><input class="form-control element-style"
                                                                               type="text"
                                                                               id="style-border-bottom-right-radius"
                                                                               style="height: 31px;width: 300%;"
                                                                               style-data-type="border-bottom-right-radius">
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card default-tab">
                            <div class="card-header" role="tab">
                                <h5 class="mb-0"><a data-toggle="collapse" aria-expanded="false"
                                                    aria-controls="accordion-2 .item-8" href="div#accordion-2 .item-8">Background
                                        Image</a></h5>
                            </div>
                            <div class="collapse item-8" role="tabpanel" data-parent="#accordion-2">
                                <div class="card-body">
                                    <form class="form-horizontal">
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Image</label>
                                            <div class="col-sm-10"><input class="form-control element-style image-class"
                                                                          type="text" id="style-background-image"
                                                                          style-data-type="background-image"><input
                                                        type="file" class="upload-btn" accept="image/*"
                                                        data-type="background-image"
                                                        attr-type="style"></div>
                                        </div>
                                    </form>
                                    <form class="form-horizontal">
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Repeat</label>
                                            <div class="col-sm-10"><select class="form-control element-style"
                                                                           id="style-background-repeat"
                                                                           style-data-type="background-repeat">
                                                    <option value="" selected="">Default</option>
                                                    <option value="repeat-x">Repeat-x</option>
                                                    <option value="repeat-y">Repeat-y</option>
                                                    <option value="no-repeat">No-repeat</option>
                                                </select></div>
                                        </div>
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Size</label>
                                            <div class="col-sm-10"><select class="form-control element-style"
                                                                           id="style-background-size"
                                                                           style-data-type="background-size">
                                                    <option value="" selected="">Default</option>
                                                    <option value="contain">Contain</option>
                                                    <option value="cover">Cover</option>
                                                </select></div>
                                        </div>
                                    </form>
                                    <div class="d-flex">
                                        <form class="form-horizontal">
                                            <div class="form-group"><label class="text-nowrap d-inline col-sm-2">Position
                                                    x &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                                                    &nbsp;&nbsp;</label>
                                                <div class="col-sm-10"><select class="form-control element-style"
                                                                               id="style-background-position-x"
                                                                               style-data-type="background-position-x">
                                                        <option value="">Default</option>
                                                        <option value="50%">Centre</option>
                                                        <option value="100%">Right</option>
                                                        <option value="0%">Left</option>
                                                    </select></div>
                                            </div>
                                        </form>
                                        <form class="form-horizontal">
                                            <div class="form-group"><label class="text-nowrap d-inline col-sm-2">Position
                                                    y<strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                                                        &nbsp;</strong><br></label>
                                                <div class="col-sm-10"><select class="form-control element-style"
                                                                               id="style-background-position-y"
                                                                               style-data-type="background-position-y">
                                                        <option value="">Default</option>
                                                        <option value="50%">Centre</option>
                                                        <option value="0%">Top</option>
                                                        <option value="100%">Bottom</option>
                                                    </select></div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="footer-basic">
    <div class="modal fade border rounded" role="dialog" tabindex="-1" id="login_modal"
         style="padding: 100px;margin: 0px;width: 100%;height: 100%;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="width: 498px;height: 75px;">
                    <h1 class="display-4 modal-title" style="font-size: 33px;">Login</h1>
                    <button type="button" class="close" id="close-login-form" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body" id="popup_momorizeCheck"
                     style="height: 210px;width: 498px;background-color: #f6f5fb;">
                    <label style="color: rgb(114,120,126);font-size: 14px;">Username</label> <span class="help-block"
                                                                                                   id="username-error"
                                                                                                   style="float: right"></span>
                    <form>
                        <div class="form-group" style="padding-bottom: 16px; margin-bottom: 0">
                            <input class="border rounded border-light form-control" type="text" id="popup_username"
                                   style="font-size: 14px;height: 40px;background-color: rgb(220,225,232);" required=""
                                   name="usrnm" placeholder="Username">
                        </div>

                        <label style="color: rgb(114,120,126);font-size: 14px;">Password</label> <span
                                class="help-block" id="password-error" style="float: right"></span>
                        <div class="form-group">
                            <input class="border rounded border-light form-control" type="password" id="popup_password"
                                   style="font-size: 14px;height: 40px;background-color: rgb(220,225,232);" required=""
                                   name="PW" placeholder="Password">
                        </div>


                    </form>

                </div>
                <div class="modal-footer" style="width: 498px;">
                    <button class="btn btn-primary btn-block border rounded" id="popup_loginBTN" type="submit"
                            style="height: 45px;">Sign in
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade border rounded" role="dialog" tabindex="-1" id="change_name_modal"
         style="padding: 100px;margin: 0px;width: 100%;height: 100%;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="width: 498px;height: 75px;">
                    <h1 class="display-4 modal-title" style="font-size: 33px;">Change Project Name</h1>
                    <button type="button" class="close" id="close-save-name-form" data-dismiss="modal"
                            aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body" id="popup_momorizeCheck"
                     style="height: 105px;width: 498px;background-color: #f6f5fb;">
                    <label style="color: rgb(114,120,126);font-size: 14px;">New Name</label> <span class="help-block"
                                                                                                   id="name-error"
                                                                                                   style="float: right"></span>
                    <form>
                        <div class="form-group" style="padding-bottom: 16px; margin-bottom: 0">
                            <input class="border rounded border-light form-control" type="text" id="popup_change_name"
                                   style="font-size: 14px;height: 40px;background-color: rgb(220,225,232);" required=""
                                   name="projectname" placeholder="Name">
                        </div>
                    </form>

                </div>
                <div class="modal-footer" style="width: 498px;">
                    <button class="btn btn-primary btn-block border rounded" id="popup_save_name_BTN" type="submit"
                            style="height: 45px;">Save
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade border rounded" role="dialog" tabindex="-1" id="new_page_modal"
         style="padding: 100px;margin: 0px;width: 100%;height: 100%;">
        <div class="modal-dialog" role="document" style=" max-width: 650px">
            <div class="modal-content">
                <div class="modal-header" style="width: 648px;height: 75px;">
                    <h1 class="display-4 modal-title" style="font-size: 33px;">New page</h1>
                    <button type="button" class="close" id="close-new-page-form" data-dismiss="modal"
                            aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body" id="popup_momorizeCheck" style="width: 648px;background-color: #f6f5fb;">
                    <label style="color: rgb(114,120,126);font-size: 14px;">Project Name</label> <span
                            class="help-block" id="page-name-error" style="float: right"></span>
                    <form>
                        <div class="form-group" style="padding-bottom: 16px; margin-bottom: 0">
                            <input class="border rounded border-light form-control" type="text" id="popup_new_page_name"
                                   style="font-size: 14px;height: 40px;background-color: rgb(220,225,232);" required=""
                                   name="projectname" placeholder="Name">
                        </div>
                    </form>
                    <ul id="template-list" style="display: contents">
                        <li>
                            <img id="template-default" class="highlight" src="img/white.jpg" width="150" height="100"
                                 page-src="./model/template/blank.html">
                            <span>Blank</span>
                        </li>
                        <li>
                            <img class="" src="img/empty-avatar.png" width="150" height="100"
                                 page-src="2">
                            <span>tmp1</span>
                        </li>
                        <li>
                            <img class="" src="img/empty-avatar.png" width="150" height="100"
                                 page-src="3">
                            <span>tmp1</span>
                        </li>
                        <li>
                            <img class="" src="img/empty-avatar.png" width="150" height="100"
                                 page-src="4">
                            <span>tmp1</span>
                        </li>
                        <li>
                            <img class="" src="img/empty-avatar.png" width="150" height="100"
                                 page-src="4">
                            <span>tmp1</span>
                        </li>
                    </ul>

                </div>
                <div class="modal-footer" style="width: 648px;">
                    <button class="btn btn-primary btn-block border rounded" id="popup_create_page_BTN" type="submit"
                            style="height: 45px;">Create
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade border rounded" role="dialog" tabindex="-1" id="get_support_modal"
         style="padding: 100px;margin: 0px;width: 100%;height: 100%;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="width: 498px;height: 75px;">
                    <h1 class="display-4 modal-title" style="font-size: 33px;">Contact Us</h1>
                    <button type="button" class="close" id="close-contact-form" data-dismiss="modal"
                            aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body" id="popup_momorizeCheck"
                     style="width: 498px;background-color: #f6f5fb;">

                    <form>
                        <div class="form-group row">
                            <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <span class="help-block" id="contact-name-error" style="float: right"></span>
                                <input type="text" class="form-control" id="inputName" placeholder="Your Name"
                                       style="font-size: 14px;height: 40px;background-color: rgb(220,225,232);">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <span class="help-block" id="contact-email-error" style="float: right"></span>
                                <input type="text" class="form-control" id="inputEmail" placeholder="Email Address"
                                       style="font-size: 14px;height: 40px;background-color: rgb(220,225,232);">

                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputTitle" class="col-sm-2 col-form-label">Title</label>
                            <div class="col-sm-10">
                                <span class="help-block" id="contact-title-error" style="float: right"></span>
                                <input type="text" class="form-control" id="inputTitle" placeholder="Title"
                                       style="font-size: 14px;height: 40px;background-color: rgb(220,225,232);">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputMsg" class="col-sm-2 col-form-label">Message</label>
                            <div class="col-sm-10">
                                <span class="help-block" id="contact-msg-error" style="float: right"></span>
                                <textarea type="text" class="form-control-plaintext" id="inputMsg"
                                          style="height: 200px; border: 1px solid; border-radius: 5px; background-color: white"></textarea>
                            </div>
                        </div>

                    </form>

                </div>
                <div class="modal-footer" style="width: 498px;">
                    <button class="btn btn-primary btn-block border rounded" id="popup_contact_submit" type="submit"
                            style="height: 45px;">Submit
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="lib/js/jquery.min.js"></script>
<script src="lib/js/jquery-1.12.4.js"></script>
<script src="lib/js/jquery-ui.js"></script>
<script src="lib/bootstrap/js/bootstrap.min.js"></script>
<script src="lib/js/sweetalert.min.js"></script>
<script src="js/common.js"></script>

<script src="js/editor.js"></script>
<script src="lib/js/dragdrop.js"></script>
<script src="lib/js/attribute-management.js"></script>
<script src="lib/js/undo_redo.js"></script>


</body>
</html>