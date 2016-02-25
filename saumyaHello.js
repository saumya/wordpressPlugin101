// version : 0.1.0
(function(){
	console.log('Wordpress:Plugin:SaumyaSignal-0.1.0');

})();
var SaumyaSignal = {
		test: function(){
			console.log('SaumyaSignal-0.1.0');
		},
		onPersonalOptions: function(){
			console.log('personal_options');
		},
		onShowUserProfile: function(){
			console.log('show_user_profile');
		},
		onUpdatedProfile: function(userId){
			console.log('Profile Updated for ID:'+userId);
			if(userId===undefined){
				console.log('Profile Updated : No Update');
			}else{
				console.log('Profile Updated : ID :'+userId);
			}
		}

	};
//
