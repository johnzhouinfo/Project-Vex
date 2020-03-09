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
    <link rel="stylesheet" href="lib/css/styles.min.css">

    <base href="">
    <title>Vex</title>

    <link href="css/editor.css" rel="stylesheet">

</head>
<body>


<div id="vex-builder">
    <div id="vex-nav">NAV</div>
    <div id="vex-left-top-project-list">Project List</div>
    <div id="vex-component">

        <ul id="drag-list-container">
            <li draggable="true" data-insert-html="<h1>HEADER H1</h1>"><i class="fa fa-header"></i>
                <p>Header</p></li>
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
    <div id="vex-toolbar">
        <div>
            <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link active" role="tab" data-toggle="tab" href="#tab-1">Content</a>
                </li>
                <li class="nav-item"><a class="nav-link" role="tab" data-toggle="tab" href="#tab-2">Style</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" role="tabpanel" id="tab-1">
                    <div role="tablist" id="accordion-1">
                        <div class="card">
                            <div class="card-header" role="tab">
                                <h5 class="mb-0"><a data-toggle="collapse" aria-expanded="false"
                                                    aria-controls="accordion-1 .item-1" href="div#accordion-1 .item-1">General</a>
                                </h5>
                            </div>
                            <div class="collapse item-1" role="tabpanel" data-parent="#accordion-1">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <form class="form-horizontal">
                                            <div class="form-group"><label
                                                        class="text-nowrap d-inline col-sm-2">Id</label>
                                                <div class="col-sm-10"><input class="form-control" type="text"></div>
                                            </div>
                                        </form>
                                        <form class="form-horizontal">
                                            <div class="form-group"><label
                                                        class="text-nowrap d-inline col-sm-2">Class</label>
                                                <div class="col-sm-10"><input class="form-control" type="text"></div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" role="tab">
                                <h5 class="mb-0"><a data-toggle="collapse" aria-expanded="false"
                                                    aria-controls="accordion-1 .item-2" href="div#accordion-1 .item-2">Button</a>
                                </h5>
                            </div>
                            <div class="collapse item-2" role="tabpanel" data-parent="#accordion-1">
                                <div class="card-body">
                                    <form class="form-horizontal">
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Name </label>
                                            <div class="col-sm-10"><input class="form-control" type="text"></div>
                                        </div>
                                    </form>
                                    <form class="form-horizontal">
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Text</label>
                                            <div class="col-sm-10"><input class="form-control" type="text"></div>
                                        </div>
                                    </form>
                                    <form class="form-horizontal">
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Type</label>
                                            <div class="col-sm-10"><select class="form-control"
                                                                           style="padding: 6px 15px;">
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
                                                    <input type="checkbox" id="checkbox">
                                                    <span class="slider round"></span>
                                                </label></label></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" role="tab">
                                <h5 class="mb-0"><a data-toggle="collapse" aria-expanded="false"
                                                    aria-controls="accordion-1 .item-3" href="div#accordion-1 .item-3">Link</a>
                                </h5>
                            </div>
                            <div class="collapse item-3" role="tabpanel" data-parent="#accordion-1">
                                <div class="card-body">
                                    <form class="form-horizontal">
                                        <div class="form-group"><label class="text-nowrap col-sm-2">URL</label>
                                            <div class="col-sm-10"><input class="form-control" type="text"></div>
                                        </div>
                                    </form>
                                    <form class="form-horizontal">
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Target</label>
                                            <div class="col-sm-10"><input class="form-control" type="text"></div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" role="tab">
                                <h5 class="mb-0"><a data-toggle="collapse" aria-expanded="false"
                                                    aria-controls="accordion-1 .item-4" href="div#accordion-1 .item-4">Heading</a>
                                </h5>
                            </div>
                            <div class="collapse item-4" role="tabpanel" data-parent="#accordion-1">
                                <div class="card-body">
                                    <form class="form-horizontal">
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Size</label>
                                            <div class="col-sm-10"><select class="form-control">
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
                        <div class="card">
                            <div class="card-header" role="tab">
                                <h5 class="mb-0"><a data-toggle="collapse" aria-expanded="false"
                                                    aria-controls="accordion-1 .item-5" href="div#accordion-1 .item-5">Video</a>
                                </h5>
                            </div>
                            <div class="collapse item-5" role="tabpanel" data-parent="#accordion-1">
                                <div class="card-body">
                                    <form class="form-horizontal">
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Src</label>
                                            <div class="col-sm-10"><input class="form-control" type="text"><input
                                                        type="file" accept="video/*"></div>
                                        </div>
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Width</label>
                                            <div class="col-sm-10"><input class="form-control" type="text"></div>
                                        </div>
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Height</label>
                                            <div class="col-sm-10"><input class="form-control" type="text"></div>
                                        </div>
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Muted<br><label
                                                        class="switch">
                                                    <input type="checkbox" id="checkbox">
                                                    <span class="slider round"></span>
                                                </label></label></div>
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Loop<br><label
                                                        class="switch">
                                                    <input type="checkbox" id="checkbox">
                                                    <span class="slider round"></span>
                                                </label></label></div>
                                        <div class="form-group"><label
                                                    class="text-nowrap col-sm-2">AutoPlay&nbsp;<br><label
                                                        class="switch">
                                                    <input type="checkbox" id="checkbox">
                                                    <span class="slider round"></span>
                                                </label></label></div>
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Control<br><label
                                                        class="switch">
                                                    <input type="checkbox" id="checkbox">
                                                    <span class="slider round"></span>
                                                </label></label></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" role="tab">
                                <h5 class="mb-0"><a data-toggle="collapse" aria-expanded="false"
                                                    aria-controls="accordion-1 .item-6" href="div#accordion-1 .item-6">Image</a>
                                </h5>
                            </div>
                            <div class="collapse item-6" role="tabpanel" data-parent="#accordion-1">
                                <div class="card-body">
                                    <form class="form-horizontal">
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Image</label>
                                            <div class="col-sm-10"><input class="form-control" type="text"><input
                                                        type="file" accept="image/*" multiple=""></div>
                                        </div>
                                    </form>
                                    <form class="form-horizontal">
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Width</label>
                                            <div class="col-sm-10"><input class="form-control" type="text"></div>
                                        </div>
                                    </form>
                                    <form class="form-horizontal">
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Height</label>
                                            <div class="col-sm-10"><input class="form-control" type="text"></div>
                                        </div>
                                    </form>
                                    <form class="form-horizontal">
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Alt</label>
                                            <div class="col-sm-10"><input class="form-control" type="text"></div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" role="tab">
                                <h5 class="mb-0"><a data-toggle="collapse" aria-expanded="true"
                                                    aria-controls="accordion-1 .item-7" href="div#accordion-1 .item-7">Form</a>
                                </h5>
                            </div>
                            <div class="collapse show item-7" role="tabpanel" data-parent="#accordion-1">
                                <div class="card-body">
                                    <form class="form-horizontal">
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Action</label>
                                            <div class="col-sm-10"><input class="form-control" type="text"></div>
                                        </div>
                                    </form>
                                    <form class="form-horizontal">
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Method</label>
                                            <div class="col-sm-10"><input class="form-control" type="text"></div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" role="tabpanel" id="tab-2">
                    <div role="tablist" id="accordion-2">
                        <div class="card">
                            <div class="card-header" role="tab">
                                <h5 class="mb-0"><a data-toggle="collapse" aria-expanded="false"
                                                    aria-controls="accordion-2 .item-1" href="div#accordion-2 .item-1">Display</a>
                                </h5>
                            </div>
                            <div class="collapse item-1" role="tabpanel" data-parent="#accordion-2">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <form class="form-horizontal">
                                            <div class="form-group"><label
                                                        class="text-nowrap d-inline col-sm-2">Display</label>
                                                <div class="col-sm-10"><select class="form-control">
                                                        <option value="" selected="">Default</option>
                                                        <option value="block">Block</option>
                                                        <option value="inline">Inline</option>
                                                        <option value="inline-block">Inline Block</option>
                                                        <option value="none">None</option>
                                                    </select></div>
                                            </div>
                                            <div class="form-group"><label
                                                        class="text-nowrap d-inline col-sm-2">Top</label>
                                                <div class="col-sm-10"><input class="form-control" type="text"></div>
                                            </div>
                                            <div class="form-group"><label
                                                        class="text-nowrap d-inline col-sm-2">Bottom</label>
                                                <div class="col-sm-10"><input class="form-control" type="text"></div>
                                            </div>
                                            <div class="form-group"><label
                                                        class="text-nowrap d-inline col-sm-2">Float</label>
                                                <div class="col-sm-10"><select class="form-control">
                                                        <option value="none">None</option>
                                                        <option value="left">Left</option>
                                                        <option value="right">Right</option>
                                                    </select></div>
                                            </div>
                                        </form>
                                        <form class="form-horizontal">
                                            <div class="form-group"><label class="text-nowrap d-inline col-sm-2">Position</label>
                                                <div class="col-sm-10"><select class="form-control">
                                                        <option value="" selected="">Default</option>
                                                        <option value="static">Static</option>
                                                        <option value="fixed">Fixed</option>
                                                        <option value="relative">Relative</option>
                                                        <option value="absolute">Absolute</option>
                                                    </select></div>
                                            </div>
                                            <div class="form-group"><label
                                                        class="text-nowrap d-inline col-sm-2">Left</label>
                                                <div class="col-sm-10"><input class="form-control" type="text"></div>
                                            </div>
                                            <div class="form-group"><label
                                                        class="text-nowrap d-inline col-sm-2">Right</label>
                                                <div class="col-sm-10"><input class="form-control" type="text"></div>
                                            </div>
                                        </form>
                                    </div>
                                    <form class="form-horizontal">
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Opacity</label>
                                            <div class="col-sm-10"><input class="form-control-range" type="range"
                                                                          step="0.1" min="0" max="1" value="1"></div>
                                        </div>
                                    </form>
                                    <div class="d-flex">
                                        <form class="form-horizontal">
                                            <div class="form-group"><label class="text-nowrap d-inline col-sm-2">BackGround
                                                    Colour</label>
                                                <div class="col-sm-10"><input type="color" value="#ffffff"></div>
                                            </div>
                                        </form>
                                        <form class="form-horizontal">
                                            <div class="form-group"><label class="text-nowrap d-inline col-sm-2">Text
                                                    Colour</label>
                                                <div class="col-sm-10"><input type="color"></div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
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
                                                <div class="col-sm-10"><select class="form-control">
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
                                                <div class="col-sm-10"><input class="form-control" type="text"></div>
                                            </div>
                                            <div class="form-group"><label class="text-nowrap col-sm-2">Text
                                                    align</label>
                                                <div class="col-sm-10"><select class="form-control">
                                                        <option value="">None</option>
                                                        <option value="left">Left</option>
                                                        <option value="center">Centre</option>
                                                        <option value="right">Right</option>
                                                        <option value="justify">Justify</option>
                                                    </select></div>
                                            </div>
                                            <div class="form-group"><label class="text-nowrap d-inline col-sm-2">Decoration
                                                    style</label>
                                                <div class="col-sm-10"><select class="form-control">
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
                                                <div class="col-sm-10"><select class="form-control">
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
                                                <div class="col-sm-10"><input class="form-control" type="text"></div>
                                            </div>
                                            <div class="form-group"><label class="text-nowrap col-sm-2">Text
                                                    decoration</label>
                                                <div class="col-sm-10"><select class="form-control">
                                                        <option value="">None</option>
                                                        <option value="uderline">Underline</option>
                                                        <option value="overline">Overline</option>
                                                        <option value="line-through">Line Through</option>
                                                        <option value="underline overline">Underline Overline</option>
                                                    </select></div>
                                            </div>
                                            <div class="form-group"><label class="text-nowrap col-sm-2">Decoration
                                                    colour</label>
                                                <div class="col-sm-10"><input type="color" value="#ffffff"></div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" role="tab">
                                <h5 class="mb-0"><a data-toggle="collapse" aria-expanded="false"
                                                    aria-controls="accordion-2 .item-3" href="div#accordion-2 .item-3">Size</a>
                                </h5>
                            </div>
                            <div class="collapse item-3" role="tabpanel" data-parent="#accordion-2">
                                <div class="card-body">
                                    <form class="form-horizontal">
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Width</label>
                                            <div class="col-sm-10">
                                                <div class="d-flex"><input class="form-control" type="text"
                                                                           style="height: 31px;width: 300%;"><select
                                                            class="custom-select custom-select-sm d-flex"
                                                            style="filter: saturate(148%);">
                                                        <option value="px">px</option>
                                                        <option value="em">em</option>
                                                        <option value="%">%</option>
                                                        <option value="rem">rem</option>
                                                        <option value="auto">auto</option>
                                                    </select></div>
                                            </div>
                                        </div>
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Height</label>
                                            <div class="col-sm-10">
                                                <div class="d-flex"><input class="form-control" type="text"
                                                                           style="height: 31px;width: 300%;"><select
                                                            class="custom-select custom-select-sm d-flex"
                                                            style="filter: saturate(148%);">
                                                        <option value="px">px</option>
                                                        <option value="em">em</option>
                                                        <option value="%">%</option>
                                                        <option value="rem">rem</option>
                                                        <option value="auto">auto</option>
                                                    </select></div>
                                            </div>
                                        </div>
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Min Width</label>
                                            <div class="col-sm-10">
                                                <div class="d-flex"><input class="form-control" type="text"
                                                                           style="height: 31px;width: 300%;"><select
                                                            class="custom-select custom-select-sm d-flex"
                                                            style="filter: saturate(148%);">
                                                        <option value="px">px</option>
                                                        <option value="em">em</option>
                                                        <option value="%">%</option>
                                                        <option value="rem">rem</option>
                                                        <option value="auto">auto</option>
                                                    </select></div>
                                            </div>
                                        </div>
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Min Height</label>
                                            <div class="col-sm-10">
                                                <div class="d-flex"><input class="form-control" type="text"
                                                                           style="height: 31px;width: 300%;"><select
                                                            class="custom-select custom-select-sm d-flex"
                                                            style="filter: saturate(148%);">
                                                        <option value="px">px</option>
                                                        <option value="em">em</option>
                                                        <option value="%">%</option>
                                                        <option value="rem">rem</option>
                                                        <option value="auto">auto</option>
                                                    </select></div>
                                            </div>
                                        </div>
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Max Width</label>
                                            <div class="col-sm-10">
                                                <div class="d-flex"><input class="form-control" type="text"
                                                                           style="height: 31px;width: 300%;"><select
                                                            class="custom-select custom-select-sm d-flex"
                                                            style="filter: saturate(148%);">
                                                        <option value="px">px</option>
                                                        <option value="em">em</option>
                                                        <option value="%">%</option>
                                                        <option value="rem">rem</option>
                                                        <option value="auto">auto</option>
                                                    </select></div>
                                            </div>
                                        </div>
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Max Height</label>
                                            <div class="col-sm-10">
                                                <div class="d-flex"><input class="form-control" type="text"
                                                                           style="height: 31px;width: 300%;"><select
                                                            class="custom-select custom-select-sm d-flex"
                                                            style="filter: saturate(148%);">
                                                        <option value="px">px</option>
                                                        <option value="em">em</option>
                                                        <option value="%">%</option>
                                                        <option value="rem">rem</option>
                                                        <option value="auto">auto</option>
                                                    </select></div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" role="tab">
                                <h5 class="mb-0"><a data-toggle="collapse" aria-expanded="false"
                                                    aria-controls="accordion-2 .item-4" href="div#accordion-2 .item-4">Margin</a>
                                </h5>
                            </div>
                            <div class="collapse item-4" role="tabpanel" data-parent="#accordion-2">
                                <div class="card-body">
                                    <form class="form-horizontal">
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Top</label>
                                            <div class="col-sm-10">
                                                <div class="d-flex"><input class="form-control" type="text"
                                                                           style="height: 31px;width: 300%;"><select
                                                            class="custom-select custom-select-sm d-flex"
                                                            style="filter: saturate(148%);">
                                                        <option value="px">px</option>
                                                        <option value="em">em</option>
                                                        <option value="%">%</option>
                                                        <option value="rem">rem</option>
                                                        <option value="auto">auto</option>
                                                    </select></div>
                                            </div>
                                        </div>
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Right</label>
                                            <div class="col-sm-10">
                                                <div class="d-flex"><input class="form-control" type="text"
                                                                           style="height: 31px;width: 300%;"><select
                                                            class="custom-select custom-select-sm d-flex"
                                                            style="filter: saturate(148%);">
                                                        <option value="px">px</option>
                                                        <option value="em">em</option>
                                                        <option value="%">%</option>
                                                        <option value="rem">rem</option>
                                                        <option value="auto">auto</option>
                                                    </select></div>
                                            </div>
                                        </div>
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Bottom</label>
                                            <div class="col-sm-10">
                                                <div class="d-flex"><input class="form-control" type="text"
                                                                           style="height: 31px;width: 300%;"><select
                                                            class="custom-select custom-select-sm d-flex"
                                                            style="filter: saturate(148%);">
                                                        <option value="px">px</option>
                                                        <option value="em">em</option>
                                                        <option value="%">%</option>
                                                        <option value="rem">rem</option>
                                                        <option value="auto">auto</option>
                                                    </select></div>
                                            </div>
                                        </div>
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Left</label>
                                            <div class="col-sm-10">
                                                <div class="d-flex"><input class="form-control" type="text"
                                                                           style="height: 31px;width: 300%;"><select
                                                            class="custom-select custom-select-sm d-flex"
                                                            style="filter: saturate(148%);">
                                                        <option value="px">px</option>
                                                        <option value="em">em</option>
                                                        <option value="%">%</option>
                                                        <option value="rem">rem</option>
                                                        <option value="auto">auto</option>
                                                    </select></div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" role="tab">
                                <h5 class="mb-0"><a data-toggle="collapse" aria-expanded="false"
                                                    aria-controls="accordion-2 .item-5" href="div#accordion-2 .item-5">Padding</a>
                                </h5>
                            </div>
                            <div class="collapse item-5" role="tabpanel" data-parent="#accordion-2">
                                <div class="card-body">
                                    <form class="form-horizontal">
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Top</label>
                                            <div class="col-sm-10">
                                                <div class="d-flex"><input class="form-control" type="text"
                                                                           style="height: 31px;width: 300%;"><select
                                                            class="custom-select custom-select-sm d-flex"
                                                            style="filter: saturate(148%);">
                                                        <option value="px">px</option>
                                                        <option value="em">em</option>
                                                        <option value="%">%</option>
                                                        <option value="rem">rem</option>
                                                        <option value="auto">auto</option>
                                                    </select></div>
                                            </div>
                                        </div>
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Right</label>
                                            <div class="col-sm-10">
                                                <div class="d-flex"><input class="form-control" type="text"
                                                                           style="height: 31px;width: 300%;"><select
                                                            class="custom-select custom-select-sm d-flex"
                                                            style="filter: saturate(148%);">
                                                        <option value="px">px</option>
                                                        <option value="em">em</option>
                                                        <option value="%">%</option>
                                                        <option value="rem">rem</option>
                                                        <option value="auto">auto</option>
                                                    </select></div>
                                            </div>
                                        </div>
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Bottom</label>
                                            <div class="col-sm-10">
                                                <div class="d-flex"><input class="form-control" type="text"
                                                                           style="height: 31px;width: 300%;"><select
                                                            class="custom-select custom-select-sm d-flex"
                                                            style="filter: saturate(148%);">
                                                        <option value="px">px</option>
                                                        <option value="em">em</option>
                                                        <option value="%">%</option>
                                                        <option value="rem">rem</option>
                                                        <option value="auto">auto</option>
                                                    </select></div>
                                            </div>
                                        </div>
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Left</label>
                                            <div class="col-sm-10">
                                                <div class="d-flex"><input class="form-control" type="text"
                                                                           style="height: 31px;width: 300%;"><select
                                                            class="custom-select custom-select-sm d-flex"
                                                            style="filter: saturate(148%);">
                                                        <option value="px">px</option>
                                                        <option value="em">em</option>
                                                        <option value="%">%</option>
                                                        <option value="rem">rem</option>
                                                        <option value="auto">auto</option>
                                                    </select></div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" role="tab">
                                <h5 class="mb-0"><a data-toggle="collapse" aria-expanded="false"
                                                    aria-controls="accordion-2 .item-6" href="div#accordion-2 .item-6">Border</a>
                                </h5>
                            </div>
                            <div class="collapse item-6" role="tabpanel" data-parent="#accordion-2">
                                <div class="card-body">
                                    <form class="form-horizontal">
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Style</label>
                                            <div class="col-sm-10"><select class="form-control">
                                                    <option value="">Default</option>
                                                    <option value="solid">Solid</option>
                                                    <option value="dotted">Dotted</option>
                                                    <option value="dashed">Dashed</option>
                                                </select></div>
                                        </div>
                                    </form>
                                    <div class="form-group"><label class="text-nowrap col-sm-2">Width</label>
                                        <div class="col-sm-10">
                                            <div class="d-flex"><input type="text"
                                                                       style="height: 31px;width: 300%;"><select
                                                        class="custom-select custom-select-sm d-flex"
                                                        style="filter: saturate(148%);">
                                                    <option value="px">px</option>
                                                    <option value="em">em</option>
                                                    <option value="%">%</option>
                                                    <option value="rem">rem</option>
                                                    <option value="auto">auto</option>
                                                </select></div>
                                        </div>
                                    </div>
                                    <div class="form-group"><label class="text-nowrap d-inline col-sm-2">Colour</label>
                                        <div class="col-sm-10"><input type="color" value="#ffffff"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" role="tab">
                                <h5 class="mb-0"><a data-toggle="collapse" aria-expanded="false"
                                                    aria-controls="accordion-2 .item-7" href="div#accordion-2 .item-7">Border
                                        radius</a></h5>
                            </div>
                            <div class="collapse item-7" role="tabpanel" data-parent="#accordion-2">
                                <div class="card-body">
                                    <form class="form-horizontal">
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Top Left</label>
                                            <div class="col-sm-10">
                                                <div class="d-flex"><input class="form-control" type="text"
                                                                           style="height: 31px;width: 300%;"><select
                                                            class="custom-select custom-select-sm d-flex"
                                                            style="filter: saturate(148%);">
                                                        <option value="px">px</option>
                                                        <option value="em">em</option>
                                                        <option value="%">%</option>
                                                        <option value="rem">rem</option>
                                                        <option value="auto">auto</option>
                                                    </select></div>
                                            </div>
                                        </div>
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Top Right</label>
                                            <div class="col-sm-10">
                                                <div class="d-flex"><input class="form-control" type="text"
                                                                           style="height: 31px;width: 300%;"><select
                                                            class="custom-select custom-select-sm d-flex"
                                                            style="filter: saturate(148%);">
                                                        <option value="px">px</option>
                                                        <option value="em">em</option>
                                                        <option value="%">%</option>
                                                        <option value="rem">rem</option>
                                                        <option value="auto">auto</option>
                                                    </select></div>
                                            </div>
                                        </div>
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Bottom Left</label>
                                            <div class="col-sm-10">
                                                <div class="d-flex"><input class="form-control" type="text"
                                                                           style="height: 31px;width: 300%;"><select
                                                            class="custom-select custom-select-sm d-flex"
                                                            style="filter: saturate(148%);">
                                                        <option value="px">px</option>
                                                        <option value="em">em</option>
                                                        <option value="%">%</option>
                                                        <option value="rem">rem</option>
                                                        <option value="auto">auto</option>
                                                    </select></div>
                                            </div>
                                        </div>
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Bottom Right</label>
                                            <div class="col-sm-10">
                                                <div class="d-flex"><input class="form-control" type="text"
                                                                           style="height: 31px;width: 300%;"><select
                                                            class="custom-select custom-select-sm d-flex"
                                                            style="filter: saturate(148%);">
                                                        <option value="px">px</option>
                                                        <option value="em">em</option>
                                                        <option value="%">%</option>
                                                        <option value="rem">rem</option>
                                                        <option value="auto">auto</option>
                                                    </select></div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" role="tab">
                                <h5 class="mb-0"><a data-toggle="collapse" aria-expanded="true"
                                                    aria-controls="accordion-2 .item-8" href="div#accordion-2 .item-8">Background
                                        Image</a></h5>
                            </div>
                            <div class="collapse show item-8" role="tabpanel" data-parent="#accordion-2">
                                <div class="card-body">
                                    <form class="form-horizontal">
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Image</label>
                                            <div class="col-sm-10"><input class="form-control" type="text"><input
                                                        type="file" accept="image/*"></div>
                                        </div>
                                    </form>
                                    <form class="form-horizontal">
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Repeat</label>
                                            <div class="col-sm-10"><select class="form-control">
                                                    <option value="" selected="">Default</option>
                                                    <option value="repeat-x">Repeat-x</option>
                                                    <option value="repeat-y">Repeat-y</option>
                                                    <option value="no-repeat">No-repeat</option>
                                                </select></div>
                                        </div>
                                        <div class="form-group"><label class="text-nowrap col-sm-2">Size</label>
                                            <div class="col-sm-10"><select class="form-control">
                                                    <option value="" selected="">Default</option>
                                                    <option value="contain">Contain</option>
                                                    <option value="cover">Cover</option>
                                                </select></div>
                                        </div>
                                    </form>
                                    <div class="d-flex">
                                        <form class="form-horizontal">
                                            <div class="form-group"><label class="text-nowrap d-inline col-sm-2">Position
                                                    x</label>
                                                <div class="col-sm-10"><select class="form-control">
                                                        <option value="">Default</option>
                                                        <option value="50%">Centre</option>
                                                        <option value="100%">Right</option>
                                                        <option value="0%">Left</option>
                                                    </select></div>
                                            </div>
                                        </form>
                                        <form class="form-horizontal">
                                            <div class="form-group"><label class="text-nowrap d-inline col-sm-2">Position
                                                    y</label>
                                                <div class="col-sm-10"><select class="form-control">
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

    <script src="lib/js/jquery.min.js"></script>
    <script src="lib/bootstrap/js/bootstrap.min.js"></script>
    <script src="lib/js/script.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


    <script src="js/editor.js"></script>
    <script src="lib/js/dragdrop.js"></script>
    <script src="lib/js/style-modify-mgnt.js"></script>

</body>
</html>