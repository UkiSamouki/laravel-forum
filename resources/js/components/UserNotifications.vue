<template>
	
	
		
		<li class="nav-item dropdown" style="list-style: none" v-if="notifications.length">
                            
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" 
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Notifications
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                    <a :href="notification.data.link"  class="dropdown-item" v-for="notification in notifications"
                    v-text="notification.data.message" @click="markAsRead(notification)">
                    </a><br>
                    
                </div>
              </li>


</template>

<script>
	
	export default {

			data(){

				return { notifications: false}
			},

			created(){

				axios.get("/profiles/" + App.user.name + "/notifications")
					.then(response => this.notifications = response.data);
			},
			methods:{

				markAsRead(notification){

					axios.delete("/profiles/"+ window.App.user.name + "/notifications/" + notification.id)
				}
			}
	};

</script>