(function () {
	'use strict';

	window.addEventListener('DOMContentLoaded', function () {
		new Vue({
			el: '#pnoFormsOptions',
			data: {
				showNewForm: false,
				test: 'foobar',
			},
			methods: {
				deleteForm(id) {
					this.$refs[id].parentNode.removeChild(this.$refs[id]);
				}
			}
		});
	});

})();
