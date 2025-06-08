class AxiosRequest {
	static post(url, data, callbacks, options = {}) {
		axios.post(url, data, options)
		.then(function(response) {
			var res = response.data;
			if (res.status == "error") {
				console.log(res.errors);
				callbacks.error(res);
				return;
			}

			callbacks.success(res);

			// Toast message
			console.log("AxiosRequest post: success");
		}).catch(function(error) {
			console.log(error);
			if ("except" in callbacks) {
				callbacks.except(error);
			}
		}).finally(function() {
			if ("finally" in callbacks) {
				callbacks.finally();
			}
		});
	}

	static get(url, callbacks) {
		axios.get(url)
		.then(function(response) {
			var res = response.data;
			if (res.status == "error") {
				console.log(res.errors);
				callbacks.error(res);
				return;
			}

			callbacks.success(res);

			// Toast message
			console.log("AxiosRequest get: success");
		}).catch(function(error) {
			console.log(error);
			if ("except" in callbacks) {
				callbacks.except(error);
			}
		}).finally(function() {
			if ("finally" in callbacks) {
				callbacks.finally();
			}
		});
	}
}

class Storage {
	static get(key) {
		var storage = window.localStorage;
		return storage.getItem(key);
	}

	static add(key, value) {
		var storage = window.localStorage;
		storage.setItem(key, value);
	}

	static exists(key) {
		var storage = window.localStorage;
		return !storage.getItem(key)? false : true;
	}

	static remove(key) {
		var storage = window.localStorage;
		storage.removeItem(key);
	}

	static clear() {
		var storage = window.localStorage;
		storage.clear();
	}
}

class Cart {

	static all() {
		var items = Storage.get('cart'); // objet (key value pair) of items objects
		if (!items) {
			items = {};
		} else {
			// @Note not perfect
			items = JSON.parse(items);
		}

		return items;
	}

	static add(key, item) {
		var items = this.all();
		items["" + key] = item;

		Storage.add('cart', JSON.stringify(items));
	}

	static get(key) {
		var items = this.all();
		return items["" + key];
	}

	static remove(key) {
		var items = this.all();
		delete items["" + key];
		Storage.add('cart', JSON.stringify(items));
	}

	static count() {
		var items = this.all();
		return Object.keys(items).length;
	}

	static destroy() {
		Storage.clear();
	}
}

function showErrorNotificationInToast(errors) {
	let msg = "";
	for (e in errors) {
		let keys = Object.keys(errors[e]);
		msg += errors[e][keys[0]] + " ";
	}

	Vue.prototype.$toast(msg, {
		type: 'error'
	});
}

function prepareErrorObjectFromServerErrorResponse(errors) {
	let result = {};
	let keys = Object.keys(errors);
	for (let i = 0; i < keys.length; ++i) {
		let error = errors[keys[i]];
		result[keys[i]] = error[Object.keys(error)[0]];
	}

	return result;
}

function prepareFormForPost(data) {
	let keys = Object.keys(data);
	let form = new FormData();
	keys.forEach(key => form.append(key, (data[key] != undefined || data[key] != null)? data[key] : ""));

	return form;
}

function emptyObjectProperty(object, excludes = []) {
	let keys = Object.keys(object);
	keys.forEach(key => {
		if (!excludes.find(ex => ex == key)) {
			// @NOTE In javascript Array and object both are typeof Object
			// if array checking is needed then use Array.isArray(arr);
			if (object[key] && typeof object[key] === "object") {
				emptyObjectProperty(object[key]);
			} else {
				object[key] = '';
			}
		}
	});

	return object;
}

// Add show/hide password EYE button
// Add data-input=togglePasswordVisibility in input:password element
(function () {
    const eyeOpenSVG = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 3c5.392 0 9.878 3.88 10.819 9-.94 5.12-5.427 9-10.819 9-5.392 0-9.878-3.88-10.819-9C2.121 6.88 6.608 3 12 3zm0 16a9.005 9.005 0 0 0 8.777-7 9.005 9.005 0 0 0-17.554 0A9.005 9.005 0 0 0 12 19zm0-2.5a4.5 4.5 0 1 1 0-9 4.5 4.5 0 0 1 0 9zm0-2a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/></svg>';
    const eyeCloseSVG = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M17.882 19.297A10.949 10.949 0 0 1 12 21c-5.392 0-9.878-3.88-10.819-9a10.982 10.982 0 0 1 3.34-6.066L1.392 2.808l1.415-1.415 19.799 19.8-1.415 1.414-3.31-3.31zM5.935 7.35A8.965 8.965 0 0 0 3.223 12a9.005 9.005 0 0 0 13.201 5.838l-2.028-2.028A4.5 4.5 0 0 1 8.19 9.604L5.935 7.35zm6.979 6.978l-3.242-3.242a2.5 2.5 0 0 0 3.241 3.241zm7.893 2.264l-1.431-1.43A8.935 8.935 0 0 0 20.777 12 9.005 9.005 0 0 0 9.552 5.338L7.974 3.76C9.221 3.27 10.58 3 12 3c5.392 0 9.878 3.88 10.819 9a10.947 10.947 0 0 1-2.012 4.592zm-9.084-9.084a4.5 4.5 0 0 1 4.769 4.769l-4.77-4.769z"/></svg>';

    const password = document.querySelector('[data-input=togglePasswordVisibility]');
    if (password) {

        let div = document.createElement('div');
        div.style.width = '30px';
        div.style.height = '30px';
        div.style.cursor = 'pointer';
        div.innerHTML = eyeCloseSVG;
        div.dataset.open = false;

        password.parentElement.style.setProperty('position', 'relative');
        div.style.setProperty('position', 'absolute');
        div.style.setProperty('right', '4px');
        div.style.setProperty('top', '12px');

        password.parentElement.appendChild(div);

        div.addEventListener('click', function(e) {
            if (this.dataset.open === 'false') {
                div.innerHTML = eyeOpenSVG;
                password.type = 'text';
                this.dataset.open = 'true';
            } else {
                div.innerHTML = eyeCloseSVG;
                password.type = 'password';
                this.dataset.open = 'false';
            }
        });
    }
})();