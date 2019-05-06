
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component('notification', require('./components/Notification.vue'));
Vue.use(require('vue-moment'));

// Vue.component('example', require('./components/Example.vue'));

const app = new Vue({
    el: '#app',
    data: {
        notifications: '',
    },
    created() {
        //Onload get all notifications
        //get unread notifications from login user
        axios.post('/notification/get').then(response => {
            // console.log(response.data.length);
        // console.log(response.data);
        // console.log(noti);
            if(response.data.length!=0){
                //add all notifications from database to notifications
                this.notifications = response.data;
            }

        });


        //only push to user who has the same id
        /*
         var userId = $('meta[name="userId"]').attr('content');
         Echo.private('App.User.' + userId).notification((notification) => {
         this.notifications.push(notification);
         });
         */

        //When new notification have been added
        //add all notification to all users who can access
        axios.post('/all_users').then(response => {
            // console.log(response.data[0].id);

            if(response.data.length!=0){
            for(var i=0;i<response.data.length;i++){
                var id=response.data[i].id;
                // console.log(id);
                Echo.private('App.User.' + id).notification((notification) => {
                    console.log(notification);
                    //use unshift instead of push to get new notification to top
                    this.notifications.unshift(notification);

                    //Alert notification using task
                    var title='';
                    var body='';
                    var icon='';
                    var link='';
                    //New product alert
                    if (notification.type=='App\\Notifications\\NotifyNewProduct'){
                        title='New Product';
                        body=notification.data.pro.name;
                        icon='/storage/notify/new_product.png';
                        link='/products/id/' + notification.data.pro.id;
                    }else if(notification.type=='App\\Notifications\\NotifyLowStock'){
                        title='Low Stock';
                        body=notification.data.pro.name;
                        icon='/storage/notify/low.png';
                        link='/products/id/' + notification.data.pro.id;
                    }else if(notification.type=='App\\Notifications\\NotifyPMReminder'){
                        title='PM Reminder';
                        body=notification.data.cus.name;
                        icon='/storage/notify/follow_up.png';
                        link='/customers/id/' + notification.data.cus.id_number;
                    }else if(notification.type=='App\\Notifications\\NotifyPostServiceFollowUp'){
                        title='Post Service';
                        body=notification.data.cus.name;
                        icon='/storage/notify/follow_up2.png';
                        link='/customers/id/' + notification.data.cus.id_number;
                    }

                    Notification.requestPermission( permission => {
                        let notification = new Notification(title, {
                            body: body, // content for the alert
                            icon: icon // optional image url
                        });


                    // link to page on clicking the notification
                    notification.onclick = () => {
                        window.open(link);

                    };
                });

            });
            }
        }

        });

    }
});