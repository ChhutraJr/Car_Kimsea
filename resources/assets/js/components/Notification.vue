
<template>
    <li class="dropdown custom-dropdown notifications-menu">
        <a id="notify-r" href="#" class=" nav-link" data-toggle="dropdown" aria-expanded="false">
            <i class="icon-notifications "></i>
            <span class="badge badge-danger badge-mini rounded-circle">{{ notifications.length }}</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-notify">
            <li class="header" v-if="notifications.length==1">You have {{ notifications.length }} notification</li>
            <li class="header" v-if="notifications.length>1">You have {{ notifications.length }} notifications</li>
            <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                    <!--Loop all notifications-->
                    <li v-for="notification in notifications">
                        <!--New Product-->
                        <a href="#" v-if="notification.type == 'App\\Notifications\\NotifyNewProduct'" v-on:click="MarkAsRead(notification)">
                            <div class="avatar float-left">
                                <!--Show profile picture-->
                                <img v-bind:src="'/storage/'+notification.data.user.image" alt="">
                                <!--<span class="avatar-badge online"></span>-->
                            </div>
                            <h6 class="f-12 profile-name-cl">
                                <!--Show user first name last name-->
                                <b>{{ notification.data.user.first_name }} {{ notification.data.user.last_name  }}</b>
                                has add a new product.
                            </h6>
                            <!--Show product name-->
                            <p class="noti-p f-12 "><i class="noti-pro qtip tip-top" v-bind:data-tip="'Total Qty: '+notification.data.pro.total_qty"><span class="icon icon-package2"></span></i>{{ notification.data.pro.name}}
                                <!--Time-->
                                <small class="turn-right float-right"><i class="icon icon-clock-o noti-clock-cl"></i>{{ notification.data.created_at.date | moment("from") }}</small>
                            </p>

                        </a>

                        <!--Low Stock-->
                        <a href="#" v-else-if="notification.type == 'App\\Notifications\\NotifyLowStock'" v-on:click="MarkAsRead(notification)">
                            <div class="avatar float-left">
                                <!--Show picture-->
                                <img  v-bind:src="'/storage/notify/low.png'" alt="">
                                <!--<span class="avatar-badge online"></span>-->
                            </div>
                            <h6 class="f-12 profile-name-cl">
                                Low Stock
                            </h6>
                            <!--Show product name-->
                            <p class="noti-p f-12 "><i class="noti-pro qtip tip-top" v-bind:data-tip="'Only '+notification.data.pro.current_qty+' qty left'"><span class="icon icon-package2 low-stock"></span></i>{{notification.data.pro.name}}
                                <!--Time-->
                                <small class="turn-right float-right"><i class="icon icon-clock-o noti-clock-cl"></i>{{ notification.data.created_at.date | moment("from") }}</small>
                            </p>
                        </a>


                        <!--PM Reminder-->
                        <a href="#" v-else-if="notification.type == 'App\\Notifications\\NotifyPMReminder'" v-on:click="MarkAsRead(notification)">
                            <div class="avatar float-left">
                                <!--Show picture-->
                                <img  v-bind:src="'/storage/notify/follow_up.png'" alt="">
                                <!--<span class="avatar-badge online"></span>-->
                            </div>
                            <h6 class="f-12 profile-name-cl">
                                PM Reminder
                            </h6>
                            <!--Show customer name-->
                            <p class="noti-p f-12">
                                <!--If no service on customer-->
                                <i v-if="notification.data.first_service==''" class="noti-pro qtip tip-top" v-bind:data-tip="'No Services Found'"><span class="icon icon-people"></span></i>
                                <!--Show first service on customer-->
                                <i v-if="notification.data.first_service!=''" class="noti-pro qtip tip-top" v-bind:data-tip="'First Service: '+FormatDate(notification.data.first_service)"><span class="icon icon-people"></span></i>
                                {{notification.data.cus.name}}
                                <!--Time-->
                                <small class="turn-right float-right"><i class="icon icon-clock-o noti-clock-cl"></i>{{ notification.data.created_at.date | moment("from") }}</small>
                            </p>
                        </a>


                        <!--Post Service Follow Up-->
                        <a href="#" v-else-if="notification.type == 'App\\Notifications\\NotifyPostServiceFollowUp'" v-on:click="MarkAsRead(notification)">
                            <div class="avatar float-left">
                                <!--Show picture-->
                                <img  v-bind:src="'/storage/notify/follow_up2.png'" alt="">
                                <!--<span class="avatar-badge online"></span>-->
                            </div>
                            <h6 class="f-12 profile-name-cl">
                                Post Service
                            </h6>

                            <!--Show customer name-->
                            <p class="noti-p f-12">
                                <!--If no service on customer-->
                                <i v-if="notification.data.first_service==''" class="noti-pro qtip tip-top" v-bind:data-tip="'No Services Found'"><span class="icon icon-people"></span></i>
                                <!--Show first service on customer-->
                                <i v-if="notification.data.first_service!=''" class="noti-pro qtip tip-top" v-bind:data-tip="'First Service: '+FormatDate(notification.data.first_service)"><span class="icon icon-people"></span></i>
                                {{notification.data.cus.name}}
                                <!--Time-->
                                <small class="turn-right float-right"><i class="icon icon-clock-o noti-clock-cl"></i>{{ notification.data.created_at.date | moment("from") }}</small>
                            </p>
                        </a>

                    </li>

                    <!--If no notification-->
                    <li v-if="notifications.length == 0" style="text-align: center;">
                        There is no new notifications
                    </li>

                    <!--<li>
                        <a href="#">
                            <i class="icon icon-data_usage text-success"></i> 5 new members joined today
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="icon icon-data_usage text-danger"></i> 5 new members joined today
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="icon icon-data_usage text-yellow"></i> 5 new members joined today
                        </a>
                    </li>-->
                </ul>
            </li>
            <li v-if="notifications.length>0" class="footer p-2 text-center view-all-noti"><a  class="view-all-noti" href="#">Clear all</a></li>
        </ul>
    </li>

</template>

<script>
    export default {
        props: ['notifications'],
        methods: {
            MarkAsRead: function(notification) {
                var data = {
                    id: notification.id
                };
                axios.post('/notification/read', data).then(response => {
                    if (notification.type=='App\\Notifications\\NotifyNewProduct'||notification.type=='App\\Notifications\\NotifyLowStock'){
                        window.location.href = "/products/id/" + notification.data.pro.id;
                    }else if(notification.type=='App\\Notifications\\NotifyPMReminder'||notification.type=='App\\Notifications\\NotifyPostServiceFollowUp'){
                        window.location.href = "/customers/id/" + notification.data.cus.id_number;
                    }

                });
            },
            FormatDate: function (date) {
                return moment(date).format('D MMM, Y');
            }

        },
    }
</script>
