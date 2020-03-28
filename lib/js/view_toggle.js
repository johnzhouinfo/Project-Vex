function toggleMobile(){
    console.log("toggle mobile");
    var page_view = $('#iframe1').contents().find('meta[name="viewport"]').attr('content');
    // console.log(page_view);
    if( page_view =='width= 1440px;'){
        page_view='width= 400px;';
    }else{
        page_view='width= 1440px;';
    }
}