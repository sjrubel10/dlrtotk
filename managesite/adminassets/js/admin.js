$(document).ready(function() {
    var is_post_loaded = 0;
    $("#adminContainer").on("click", ".adminTabChange", function () {
        let adminNavId = $(this).attr('id');
        let adminNavHolderId = adminNavId + '_holder';

        $("#" + adminNavId).addClass('adminNavSelect');
        $("#" + adminNavId).siblings().removeClass('adminNavSelect');

        $("#" + adminNavHolderId).show();
        $("#" + adminNavHolderId).siblings().hide();

        if (adminNavId === 'manage-buy_sell') {
            if ( is_post_loaded === 0) {
                is_post_loaded++;
                let loadedIds = "";
                let display_limit = 20;
                let end_point = "../main/jsvalidation/buySellDataForManage.php";
                let body_data = {
                    action: 'buy',
                    limit: display_limit,
                    loadedIds: loadedIds
                };
                let adminNavHolderId = 'publish_holder';
                const display_type = 'display_news_control';
                var buyData = get_data_from_api(end_point, body_data, adminNavHolderId, display_type );
            }
        }
    });

    $("#adminContainer").on("click", ".makeActiveSubmit", function () {
        let clickedId = $(this).attr('id');
        let clickedIdary = clickedId.split('_');
        let userkey = clickedIdary[1];
        let makeAdminCheckName = 'isActive_'+userkey;
        const findChecked = $("#"+makeAdminCheckName).is(":checked");
        const isChecked = findChecked ? 1 : 0;
        const body_data ={
            active : isChecked,
            userkey : userkey,
            deleteOrAdd:'makeActive'
        };
        const display_type = 'make_admin';
        const end_point = '../main/jsvalidation/make_active_user.php';
        const appendedId = '';
        get_data_from_api( end_point, body_data, appendedId, display_type );

    });

    $("#adminContainer").on("click", ".removeFromAdmin", function () {
        let clickedId = $(this).attr('id');
        let clickedIdary = clickedId.split('_');
        let userkey = clickedIdary[1];
        const body_data ={
            admin : 0,
            userkey : userkey,
            admin_level:0,
            deleteOrAdd:'removeAdmin'
        };
        const display_type = 'make_admin';
        const end_point = '../main/jsvalidation/make_delete_admin.php';
        const appendedId = '';
        get_data_from_api( end_point, body_data, appendedId, display_type );
    });

});



