$(".js-select2").each(function(){
	$(this).select2({
		minimumResultsForSearch: 20,
		dropdownParent: $(this).next('.dropDownSelect2')
	});
});

$('.parallax100').parallax100();

$('.gallery-lb').each(function() { // the containers for all your galleries
	$(this).magnificPopup({
        delegate: 'a', // the selector for gallery item
        type: 'image',
        gallery: {
        	enabled:true
        },
        mainClass: 'mfp-fade'
    });
});

$('.js-addwish-b2').on('click', function(e){
	e.preventDefault();
});

$('.js-addwish-b2').each(function(){
	var nameProduct = $(this).parent().parent().find('.js-name-b2').html();
	$(this).on('click', function(){
		Swal.fire({
			position: 'top-center',
			icon: 'success',
			title: nameProduct,
			text: '¡Se agrego al carrito',
			showConfirmButton: false,
			timer: 1500
		})

		
		//$(this).addClass('js-addedwish-b2');
		//$(this).off('click');
	});
});

$('.js-addwish-detail').each(function(){
	var nameProduct = $(this).parent().parent().parent().find('.js-name-detail').html();

	$(this).on('click', function(){
		Swal.fire({
			position: 'top-center',
			icon: 'success',
			title: nameProduct,
			text: 'is added to wishlist !',
			showConfirmButton: false,
			timer: 1500
		})

		$(this).addClass('js-addedwish-detail');
		$(this).off('click');
	});
});

/*---------------------------------------------*/

$('.js-addcart-detail').each(function(){
	let nameProduct = $(this).parent().parent().parent().parent().find('.js-name-detail').html();
	let cant = 1;
	$(this).on('click', function(){
		let id = this.getAttribute('id');
		if(document.querySelector('#cant-product')){
			cant = document.querySelector('#cant-product').value;
		}
		if(this.getAttribute('pr')){
			cant = this.getAttribute('pr');
		}

		if(isNaN(cant) || cant < 1){
			const Toast = Swal.mixin({
				toast: true,
				position: 'top-end',
				showConfirmButton: false,
				timer: 3000,
				timerProgressBar: true,
				didOpen: (toast) => {
				  toast.addEventListener('mouseenter', Swal.stopTimer)
				  toast.addEventListener('mouseleave', Swal.resumeTimer)
				}
			  })
			  
			  Toast.fire({
				icon: 'error',
				title: 'La cantidad debe ser mayor o igual que 1'
			  })
			return;
		} 
		let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	    let ajaxUrl = base_url+'/Tienda/addCarrito'; 
	    let formData = new FormData();
	    formData.append('id',id);
	    formData.append('cant',cant);
	    request.open("POST",ajaxUrl,true);
	    request.send(formData);
	    request.onreadystatechange = function(){
	        if(request.readyState != 4) return;
	        if(request.status == 200){
	        	let objData = JSON.parse(request.responseText);
	        	if(objData.status){
		            document.querySelector("#productosCarrito").innerHTML = objData.htmlCarrito;
		            //document.querySelectorAll(".cantCarrito")[0].setAttribute("data-notify",objData.cantCarrito);
		            //document.querySelectorAll(".cantCarrito")[1].setAttribute("data-notify",objData.cantCarrito);
		            const cants = document.querySelectorAll(".cantCarrito");
					cants.forEach(element => {
						element.setAttribute("data-notify",objData.cantCarrito)
					});
					Swal.fire({
						position: 'top-center',
						icon: 'success',
						title: nameProduct,
						text: '¡Se agrego al carrito!',
						showConfirmButton: false,
						timer: 1500
					})
	        	}else{
					const Toast = Swal.mixin({
						toast: true,
						position: 'top-end',
						showConfirmButton: false,
						timer: 3000,
						timerProgressBar: true,
						didOpen: (toast) => {
						  toast.addEventListener('mouseenter', Swal.stopTimer)
						  toast.addEventListener('mouseleave', Swal.resumeTimer)
						}
					  })
					  
					  Toast.fire({
						icon: 'error',
						title: objData.msg
					  })
	        	}
	        } 
	        return false;
	    }
	});
});

$('.js-pscroll').each(function(){
	$(this).css('position','relative');
	$(this).css('overflow','hidden');
	var ps = new PerfectScrollbar(this, {
		wheelSpeed: 1,
		scrollingThreshold: 1000,
		wheelPropagation: false,
	});

	$(window).on('resize', function(){
		ps.update();
	})
});


/*==================================================================
[ +/- num product ]*/
$('.btn-num-product-down').on('click', function(){
    let numProduct = Number($(this).next().val());
    let idpr = this.getAttribute('idpr');
    if(numProduct > 1) $(this).next().val(numProduct - 1);
    let cant = $(this).next().val();
    let idenvio = Number($(".precio_envios").attr("idenv"));
	let nomenvio = $(".precio_envios").val();
	let condescuento = 0;
	let de = "btn-num-product-down";
    if(idpr != null){
    	fntUpdateCant(idpr,cant,idenvio,nomenvio,condescuento,de);
    }
});

$('.btn-num-product-up').on('click', function(){
    let numProduct = Number($(this).prev().val());
    let idpr = this.getAttribute('idpr');
    let idenvio = Number($(".precio_envios").attr("idenv"));
    $(this).prev().val(numProduct + 1);
    let cant = $(this).prev().val();
	let nomenvio = $(".precio_envios").val();
	let de = "btn-num-product-up";
	let condescuento = 0;
	if(idpr != null){
    	fntUpdateCant(idpr,cant,idenvio,nomenvio,condescuento,de);
    }
});

//Actualizar producto
if(document.querySelector(".num-product")){
	let inputCant = document.querySelectorAll(".num-product");
	inputCant.forEach(function(inputCant) {
		inputCant.addEventListener('keyup', function(){
			let idpr = this.getAttribute('idpr');
			let cant = this.value;
			let idenvio = Number($(".precio_envios").attr("idenv"));
			let nomenvio = $(".precio_envios").val();
			let de = "num-product"
			if(idpr != null){
		    	fntUpdateCant(idpr,cant,idenvio,nomenvio,condescuento,de);
		    }
		});
	});
}

if(document.querySelector("#formRegister")){
    let formRegister = document.querySelector("#formRegister");
    formRegister.onsubmit = function(e) {
        e.preventDefault();
        let strNombre = document.querySelector('#txtNombre').value;
        let strApellido = document.querySelector('#txtApellido').value;
        let strEmail = document.querySelector('#txtEmailCliente').value;
        let intTelefono = document.querySelector('#txtTelefono').value;

        if(strApellido == '' || strNombre == '' || strEmail == '' || intTelefono == '' )
        {
			const Toast = Swal.mixin({
				toast: true,
				position: 'top-end',
				showConfirmButton: false,
				timer: 3000,
				timerProgressBar: true,
				didOpen: (toast) => {
				  toast.addEventListener('mouseenter', Swal.stopTimer)
				  toast.addEventListener('mouseleave', Swal.resumeTimer)
				}
			  })
			  
			  Toast.fire({
				icon: 'warning',
				title: 'Todos los campos son obligatorios.'
			  })
            return false;
        }

        let elementsValid = document.getElementsByClassName("valid");
        for (let i = 0; i < elementsValid.length; i++) { 
            if(elementsValid[i].classList.contains('is-invalid')) { 
				const Toast = Swal.mixin({
					toast: true,
					position: 'top-end',
					showConfirmButton: false,
					timer: 3000,
					timerProgressBar: true,
					didOpen: (toast) => {
					  toast.addEventListener('mouseenter', Swal.stopTimer)
					  toast.addEventListener('mouseleave', Swal.resumeTimer)
					}
				  })
				  
				  Toast.fire({
					icon: 'warning',
					title: 'Por favor verifique los campos en rojo.'
				  })
                return false;
            } 
        } 
        divLoading.style.display = "flex";
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Tienda/registro'; 
        let formData = new FormData(formRegister);
        request.open("POST",ajaxUrl,true);
        request.send(formData);
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                let objData = JSON.parse(request.responseText);
                if(objData.status)
                {
                    window.location.reload(false);
                }else{
					const Toast = Swal.mixin({
						toast: true,
						position: 'top-end',
						showConfirmButton: false,
						timer: 3000,
						timerProgressBar: true,
						didOpen: (toast) => {
						  toast.addEventListener('mouseenter', Swal.stopTimer)
						  toast.addEventListener('mouseleave', Swal.resumeTimer)
						}
					  })
					  
					  Toast.fire({
						icon: 'error',
						title: objData.msg
					  })
                }
            }
            divLoading.style.display = "none";
            return false;
        }
    }
}

if(document.querySelector(".methodpago")){

	let optmetodo = document.querySelectorAll(".methodpago");
    optmetodo.forEach(function(optmetodo) {
        optmetodo.addEventListener('click', function(){
        	if(this.value == "Paypal"){
        		document.querySelector("#divpaypal").classList.remove("notblock");
        		document.querySelector("#divtipopago").classList.add("notblock");
        	}else{
        		document.querySelector("#divpaypal").classList.add("notblock");
        		document.querySelector("#divtipopago").classList.remove("notblock");
        	}
        });
    });
}

function fntdelItem(element){
	//Option 1 = Modal
	//Option 2 = Vista Carrito
	let option = element.getAttribute("op");
	let idpr = element.getAttribute("idpr");
	if(option == 1 || option == 2 ){

		let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	    let ajaxUrl = base_url+'/Tienda/delCarrito'; 
	    let formData = new FormData();
	    formData.append('id',idpr);
	    formData.append('option',option);
	    request.open("POST",ajaxUrl,true);
	    request.send(formData);
	    request.onreadystatechange = function(){
	        if(request.readyState != 4) return;
	        if(request.status == 200){
	        	let objData = JSON.parse(request.responseText);
	        	if(objData.status){
	        		if(option == 1){
			            document.querySelector("#productosCarrito").innerHTML = objData.htmlCarrito;
			            const cants = document.querySelectorAll(".cantCarrito");
						cants.forEach(element => {
							element.setAttribute("data-notify",objData.cantCarrito)
						});
	        		}else{
	        			element.parentNode.parentNode.remove();
	        			document.querySelector("#subTotalCompra").innerHTML = objData.subTotal;
	        			document.querySelector("#totalCompra").innerHTML = objData.total;
	        			if(document.querySelectorAll("#tblCarrito tr").length == 1){
	            			window.location.href = base_url;
	            		}
	        		}
	        	}else{
					const Toast = Swal.mixin({
						toast: true,
						position: 'top-end',
						showConfirmButton: false,
						timer: 3000,
						timerProgressBar: true,
						didOpen: (toast) => {
						  toast.addEventListener('mouseenter', Swal.stopTimer)
						  toast.addEventListener('mouseleave', Swal.resumeTimer)
						}
					  })
					  
					  Toast.fire({
						icon: 'error',
						title: objData.msg
					  })
	        	}
	        } 
	        return false;
	    }

	}
}


if(document.querySelector("#txtDireccion")){
	let direccion = document.querySelector("#txtDireccion");
	direccion.addEventListener('keyup', function(){
		let dir = this.value;
		fntViewPago();
	});
}

if(document.querySelector("#txtCiudad")){
	let ciudad = document.querySelector("#txtCiudad");
	ciudad.addEventListener('keyup', function(){
		let c = this.value;
		fntViewPago();
	});
}

if(document.querySelector("#condiciones")){
	let opt = document.querySelector("#condiciones");
	opt.addEventListener('click', function(){
		let opcion = this.checked;
		if(opcion){
			document.querySelector('#btnCompraTotal').classList.remove("notblock");
		}else{
			document.querySelector('#btnCompraTotal').classList.add("notblock");
		}
	});
}

function fntViewPago(){
	let direccion = document.querySelector("#txtDireccion").value;
	let ciudad = document.querySelector("#txtCiudad").value;
	if(direccion == "" || ciudad == ""){
		document.querySelector('#divMetodoPago').classList.add("notblock");
	}else{
		document.querySelector('#divMetodoPago').classList.remove("notblock");
	}
}

if(document.querySelector("#btnComprar_old")){
	let btnPago = document.querySelector("#btnComprar");
	btnPago.addEventListener('click',function() { 
		let dir = document.querySelector("#txtDireccion").value;
	    let ciudad = document.querySelector("#txtCiudad").value;
	    let inttipopago = document.querySelector("#listtipopago").value; 
	    if( txtDireccion == "" || txtCiudad == "" || inttipopago =="" ){
			const Toast = Swal.mixin({
				toast: true,
				position: 'top-end',
				showConfirmButton: false,
				timer: 3000,
				timerProgressBar: true,
				didOpen: (toast) => {
				  toast.addEventListener('mouseenter', Swal.stopTimer)
				  toast.addEventListener('mouseleave', Swal.resumeTimer)
				}
			  })
			  
			  Toast.fire({
				icon: 'warning',
				title: 'Complete datos de envío'
			  })
			return;
		}else{
			divLoading.style.display = "flex";
			let request = (window.XMLHttpRequest) ? 
	                    new XMLHttpRequest() : 
	                    new ActiveXObject('Microsoft.XMLHTTP');
			let ajaxUrl = base_url+'/Tienda/procesarVenta';
			let formData = new FormData();
		    formData.append('direccion',dir);    
		   	formData.append('ciudad',ciudad);
			formData.append('inttipopago',inttipopago);
		   	request.open("POST",ajaxUrl,true);
		    request.send(formData);
		    request.onreadystatechange = function(){
		    	if(request.readyState != 4) return;
		    	if(request.status == 200){
		    		let objData = JSON.parse(request.responseText);
		    		if(objData.status){
		    			window.location = base_url+"/tienda/confirmarpedido/";
		    		}else{
						const Toast = Swal.mixin({
							toast: true,
							position: 'top-end',
							showConfirmButton: false,
							timer: 3000,
							timerProgressBar: true,
							didOpen: (toast) => {
							  toast.addEventListener('mouseenter', Swal.stopTimer)
							  toast.addEventListener('mouseleave', Swal.resumeTimer)
							}
						  })
						  
						  Toast.fire({
							icon: 'error',
							title: objData.msg
						  })
		    		}
		    	}
		    	divLoading.style.display = "none";
            	return false;
		    }
		}

	},false);
}
if(document.querySelector("#btnComprar")){
	let btnPago = document.querySelector("#btnComprar");
	btnPago.addEventListener('click',function() { 

		Swal.fire({
			title: "¿Confirmar compra?",
			text: "¿Realizaste el pago correspondiente?",
			icon: 'question',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText:
			'<i class="fa fa-thumbs-up"></i> Realizado!',
			confirmButtonAriaLabel: 'Thumbs up, great!',
			cancelButtonText:
				'<i class="fa fa-thumbs-down"></i> No!',
		  }).then((result) => {
			if (result.isConfirmed) {


				let cupon = document.querySelector("#coupon").value;

				divLoading.style.display = "flex";
				let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
				let ajaxUrl = base_url+'/Tienda/procesarVenta';
				let formData = new FormData();
				formData.append('codcupon',cupon);    
				request.open("POST",ajaxUrl,true);
				request.send(formData);
				request.onreadystatechange = function(){
					if(request.readyState != 4) return;
					if(request.status == 200){
						let objData = JSON.parse(request.responseText);
						
						if(objData.status){
							window.location = base_url+"/carrito/procesarpago/";
						}else{
							const Toast = Swal.mixin({
								toast: true,
								position: 'top-end',
								showConfirmButton: false,
								timer: 3000,
								timerProgressBar: true,
								didOpen: (toast) => {
								  toast.addEventListener('mouseenter', Swal.stopTimer)
								  toast.addEventListener('mouseleave', Swal.resumeTimer)
								}
							  })
							  
							  Toast.fire({
								icon: 'error',
								title: objData.msg
							  })
						}
					}
					divLoading.style.display = "none";
					return false;
				}

			}
		})

		

	},false);
}
if(document.querySelector("#frmSuscripcion")){
	let frmSuscripcion = document.querySelector("#frmSuscripcion");
	frmSuscripcion.addEventListener('submit',function(e) { 
		e.preventDefault();

		let nombre = document.querySelector("#nombreSuscripcion").value;
		let email = document.querySelector("#emailSuscripcion").value;

		if(nombre == ""){
			const Toast = Swal.mixin({
				toast: true,
				position: 'top-end',
				showConfirmButton: false,
				timer: 3000,
				timerProgressBar: true,
				didOpen: (toast) => {
				  toast.addEventListener('mouseenter', Swal.stopTimer)
				  toast.addEventListener('mouseleave', Swal.resumeTimer)
				}
			  })
			  
			  Toast.fire({
				icon: 'error',
				title: 'El nombre es obligatorio'
			  })
			return false;
		}

		if(!fntEmailValidate(email)){
			const Toast = Swal.mixin({
				toast: true,
				position: 'top-end',
				showConfirmButton: false,
				timer: 3000,
				timerProgressBar: true,
				didOpen: (toast) => {
				  toast.addEventListener('mouseenter', Swal.stopTimer)
				  toast.addEventListener('mouseleave', Swal.resumeTimer)
				}
			  })
			  
			  Toast.fire({
				icon: 'error',
				title: 'El email no es válido.'
			  })
			return false;
		}	
		
		divLoading.style.display = "flex";
		let request = (window.XMLHttpRequest) ? 
                    new XMLHttpRequest() : 
                    new ActiveXObject('Microsoft.XMLHTTP');
		let ajaxUrl = base_url+'/Tienda/suscripcion';
		let formData = new FormData(frmSuscripcion);
	   	request.open("POST",ajaxUrl,true);
	    request.send(formData);
	    request.onreadystatechange = function(){
	    	if(request.readyState != 4) return;
	    	if(request.status == 200){
	    		let objData = JSON.parse(request.responseText);
	    		if(objData.status){
					const Toast = Swal.mixin({
						toast: true,
						position: 'top-end',
						showConfirmButton: false,
						timer: 3000,
						timerProgressBar: true,
						didOpen: (toast) => {
						  toast.addEventListener('mouseenter', Swal.stopTimer)
						  toast.addEventListener('mouseleave', Swal.resumeTimer)
						}
					  })
					  
					  Toast.fire({
						icon: 'success',
						title: objData.msg
					  })
                	document.querySelector("#frmSuscripcion").reset();
	    		}else{
					const Toast = Swal.mixin({
						toast: true,
						position: 'top-end',
						showConfirmButton: false,
						timer: 3000,
						timerProgressBar: true,
						didOpen: (toast) => {
						  toast.addEventListener('mouseenter', Swal.stopTimer)
						  toast.addEventListener('mouseleave', Swal.resumeTimer)
						}
					  })
					  
					  Toast.fire({
						icon: 'error',
						title: objData.msg
					  })
	    		}
	    	}
	    	divLoading.style.display = "none";
        	return false;
	    
		}

	},false);
}

if(document.querySelector("#frmContacto")){
	let frmContacto = document.querySelector("#frmContacto");
	frmContacto.addEventListener('submit',function(e) { 
		e.preventDefault();

		let nombre = document.querySelector("#nombreContacto").value;
		let email = document.querySelector("#emailContacto").value;
		let mensaje = document.querySelector("#mensaje").value;

		if(nombre == ""){
			const Toast = Swal.mixin({
				toast: true,
				position: 'top-end',
				showConfirmButton: false,
				timer: 3000,
				timerProgressBar: true,
				didOpen: (toast) => {
					toast.addEventListener('mouseenter', Swal.stopTimer)
					toast.addEventListener('mouseleave', Swal.resumeTimer)
				}
			})

			Toast.fire({
				icon: 'warning',
				title: 'El nombre es obligatorio.'
			})
			return false;
		}

		if(!fntEmailValidate(email)){
			const Toast = Swal.mixin({
				toast: true,
				position: 'top-end',
				showConfirmButton: false,
				timer: 3000,
				timerProgressBar: true,
				didOpen: (toast) => {
					toast.addEventListener('mouseenter', Swal.stopTimer)
					toast.addEventListener('mouseleave', Swal.resumeTimer)
				}
			})

			Toast.fire({
				icon: 'warning',
				title: 'El email no es válido.'
			})
			return false;
		}

		if(mensaje == ""){
			const Toast = Swal.mixin({
				toast: true,
				position: 'top-end',
				showConfirmButton: false,
				timer: 3000,
				timerProgressBar: true,
				didOpen: (toast) => {
					toast.addEventListener('mouseenter', Swal.stopTimer)
					toast.addEventListener('mouseleave', Swal.resumeTimer)
				}
			})

			Toast.fire({
				icon: 'warning',
				title: 'Por favor escribe el mensaje.'
			})
			return false;
		}
		
		divLoading.style.display = "flex";
		let request = (window.XMLHttpRequest) ? 
                    new XMLHttpRequest() : 
                    new ActiveXObject('Microsoft.XMLHTTP');
		let ajaxUrl = base_url+'/Tienda/contacto';
		let formData = new FormData(frmContacto);
	   	request.open("POST",ajaxUrl,true);
	    request.send(formData);
	    request.onreadystatechange = function(){
	    	if(request.readyState != 4) return;
	    	if(request.status == 200){
	    		let objData = JSON.parse(request.responseText);
	    		if(objData.status){
					const Toast = Swal.mixin({
						toast: true,
						position: 'top-end',
						showConfirmButton: false,
						timer: 3000,
						timerProgressBar: true,
						didOpen: (toast) => {
						  toast.addEventListener('mouseenter', Swal.stopTimer)
						  toast.addEventListener('mouseleave', Swal.resumeTimer)
						}
					  })
					  
					  Toast.fire({
						icon: 'success',
						title: objData.msg
					  })
                	document.querySelector("#frmContacto").reset();
	    		}else{
					const Toast = Swal.mixin({
						toast: true,
						position: 'top-end',
						showConfirmButton: false,
						timer: 3000,
						timerProgressBar: true,
						didOpen: (toast) => {
						  toast.addEventListener('mouseenter', Swal.stopTimer)
						  toast.addEventListener('mouseleave', Swal.resumeTimer)
						}
					  })
					  
					  Toast.fire({
						icon: 'error',
						title: objData.msg
					  })
	    		}
	    	}
	    	divLoading.style.display = "none";
        	return false;
		}

	},false);
}

/* ALTERANDO EL PRECIO DE ENVIO */
$(document).on('change', '.precio_envios', function(event) {

	let idenvio = Number($('option:selected', this).attr("attrvalues"));
	let nomenvio = this.value;
    let pro = this.getAttribute('idProd');
	let cant = $(".num-product").val();
	$(this).attr("idenv",$('option:selected', this).attr("attrvalues"))
	$(this).attr("idenv",$('option:selected', this).attr("attrvalues"))
	let condescuento = 0;
	let de = "precio_envios";


	fntUpdateCant(pro,cant,idenvio,nomenvio,condescuento,de)
	// return
});

//DESCUENTO POR CUPÓN DE DESCUENTOS
$(".appcupon").on("click",function(){
	let cod = $("#coupon").val();
	let idenvio = Number($(".precio_envios").attr("idenv"));
    let pro = $(".precio_envios").attr('idProd');
	let cant = $(".num-product").val();
	let nomenvio = $(".precio_envios").val();
	
	divLoading.style.display = "flex";
	let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	let ajaxUrl = base_url+'/Tienda/validarcupon'; 
	let formData = new FormData();
	formData.append('cod',cod);
	formData.append('id',pro);
	formData.append('envio',idenvio);
	formData.append('cantidad',cant);
	request.open("POST",ajaxUrl,true);
	request.send(formData);
	request.onreadystatechange = function(){
		if(request.readyState == 4 && request.status == 200){
			let objData = JSON.parse(request.responseText);
			if(objData.status)
			{
				const Toast = Swal.mixin({
					toast: true,
					position: 'top-end',
					showConfirmButton: false,
					timer: 2000,
					timerProgressBar: true,
					didOpen: (toast) => {
					  toast.addEventListener('mouseenter', Swal.stopTimer)
					  toast.addEventListener('mouseleave', Swal.resumeTimer)
					}
				  })
				  Toast.fire({
					icon: 'success',
					title: 'Cupón aplicado.'
				  }).then(event => {
					let porcentaje = Number(objData.data.descuento);
					let de = "appcupon";
					fntUpdateCant(pro,cant,idenvio,nomenvio,porcentaje,de)
					location. reload();
				  })

			}else{
				const Toast = Swal.mixin({
					toast: true,
					position: 'top-end',
					showConfirmButton: false,
					timer: 3000,
					timerProgressBar: true,
					didOpen: (toast) => {
					  toast.addEventListener('mouseenter', Swal.stopTimer)
					  toast.addEventListener('mouseleave', Swal.resumeTimer)
					}
				  })
				  
				  Toast.fire({
					icon: 'error',
					title: objData.msg
				  })
				  
				divLoading.style.display = "none";
			}
		}
		return false;
	}



	
});


$(".pagoconyape").on("click",function(){
	$("#pagoyapeqr").show();
})
$(".pagoconplin").on("click",function(){
	$("#pagoplinqr").show();
})

// ACTUALIZAR CARRITO DE COMPRAS
function fntUpdateCant(pro,cant,idenvio,nomenvio,condescuento,de){

	if(cant <= 0){
		const Toast = Swal.mixin({
			toast: true,
			position: 'top-end',
			showConfirmButton: false,
			timer: 3000,
			timerProgressBar: true,
			didOpen: (toast) => {
			  toast.addEventListener('mouseenter', Swal.stopTimer)
			  toast.addEventListener('mouseleave', Swal.resumeTimer)
			}
		  })
		  
		  Toast.fire({
			icon: 'warning',
			title: 'La cantidad debe ser mayor o igual que 1'
		  })
		$("#showbtncomprar").html(``)
		// document.querySelector("#btnComprar").classList.add("notblock");
	}else{
		$("#showbtncomprar").html(`
		<a href="#3" id="btnComprar" class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
			Procesar pago
		</a>`)
		// document.querySelector("#btnComprar").classList.remove("notblock");
		let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	    let ajaxUrl = base_url+'/Tienda/updCarrito'; 
	    let formData = new FormData();
	    formData.append('id',pro);    
	   	formData.append('cantidad',cant);
	   	formData.append('envio',idenvio);
	   	formData.append('nomenvio',nomenvio);
	   	formData.append('preciodesc',condescuento);
	   	request.open("POST",ajaxUrl,true);
	    request.send(formData);
	    request.onreadystatechange = function(){
	    	if(request.readyState != 4) return;
	    	if(request.status == 200){
	    		let objData = JSON.parse(request.responseText);
	    		if(objData.status){
	    			let colSubtotal = document.getElementsByClassName(pro)[0];
	    			colSubtotal.cells[4].textContent = objData.totalProducto;

					if(de == "btn-num-product-up" || de == "btn-num-product-down"){
						if( objData.subTotalconDesc != "S/0.00"){
							document.querySelector("#totalCompra").innerHTML = objData.subTotalconDesc;
							document.querySelector("#new_prec").innerHTML = objData.subTotal_conDesc;
							document.querySelector("#subTotalCompra").innerHTML = objData.subTotal;
						}else{
							document.querySelector("#totalCompra").innerHTML = objData.total;
							document.querySelector("#subTotalCompra").innerHTML = objData.subTotal;
						}

						if(objData.Enviofree == "enviogratis"){
							
							$(".precio_envios").attr("disabled",true)
							$(".select2-container").css("background","#f0f0f0")
							
							$("#totalCompra").css("color","hsl(152, 51%, 52%)")
							$("#totalCompra").css("font-weight","bold")

							$(".pricesfree").show();

						}else if(objData.Enviofree == "noenviogratis"){

							$(".precio_envios").attr("disabled",false)
							$(".select2-container").css("background","#ffffff")

							$("#totalCompra").css("color","#333")
							$("#totalCompra").css("font-weight","100")


							$(".pricesfree").hide();

						}
					}else

					if(de == "precio_envios"){
						if( objData.subTotalconDesc != "S/0.00"){
							document.querySelector("#totalCompra").innerHTML = objData.subTotalconDesc;
							document.querySelector("#subTotalCompra").innerHTML = objData.subTotal;
						}else{
							document.querySelector("#totalCompra").innerHTML = objData.total;
							document.querySelector("#subTotalCompra").innerHTML = objData.subTotal;
						}
					}else{
						
							document.querySelector("#totalCompra").innerHTML = objData.total;
							document.querySelector("#subTotalCompra").innerHTML = objData.subTotal;
					}

	    		}else{
					const Toast = Swal.mixin({
						toast: true,
						position: 'top-end',
						showConfirmButton: false,
						timer: 3000,
						timerProgressBar: true,
						didOpen: (toast) => {
						  toast.addEventListener('mouseenter', Swal.stopTimer)
						  toast.addEventListener('mouseleave', Swal.resumeTimer)
						}
					  })
					  
					  Toast.fire({
						icon: 'error',
						title: objData.msg
					  })
	    		}
	    	}
	    }
	}
	return false;
}

function fntipe(tipo){
	let html_tipo_reg  = "";
	if(tipo == "new"){

		html_tipo_reg += `
		
		<label for="tipopago" class="a0"><i>Registra tus datos</i></label>

		<div class="bor8 bg0 m-b-12 a1">
			<input id="txtDniC" class="stext-111 cl8 plh3 size-111 p-lr-15" type="number" name="txtDniC" maxlength="8" placeholder="N° de DNI">
		</div>

		<div class="bor8 bg0 m-b-12 a2">
			<input id="txtNombreC" class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="state" placeholder="Nombre (Con el que aparece en tu Yape o Plin)">
		</div>

		<div class="bor8 bg0 m-b-12 a3">
			<input id="txtCelularC" class="stext-111 cl8 plh3 size-111 p-lr-15" type="number" name="txtCelularC" maxlength="9" placeholder="N° de celular">
		</div>

		<div class="bor8 bg0 m-b-12 a4">
			<input id="txtDireccionC" class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="txtDireccionC" placeholder="Dirección de envío">
		</div>

		<div class="bor8 bg0 m-b-12 a6">
			<input id="txtEmailC" class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="txtEmailC" placeholder="Correo Electrónico">
		</div>`

		$("#reg_add").html(html_tipo_reg);

		document.querySelector("#txtnewoexist").value = "new";
		// buscarDNI();
		// document.getElementById('txtNombreC').value = "";
		// document.getElementById('txtCelularC').value = "";
		
		document.querySelector("#btnCompraTotal").setAttribute("estatusRegistro","0"); //No está registrado
		document.querySelector("#btnCompraTotal").setAttribute("regClienteId","");

		document.querySelector("#new").classList.remove("buttonconfirm");
		document.querySelector("#new").classList.add("buttonconfirmSeleccionado");

		document.querySelector("#exist").classList.remove("buttonconfirmSeleccionado");
		document.querySelector("#exist").classList.add("buttonconfirm");

		document.querySelector("#showrpta").style.display = "block";
	}
	if(tipo == "exist"){
		html_tipo_reg += `
		<label for="tipopago" class="a0"><i>Registra tus datos</i></label>
		<div class="bor8 bg0 m-b-12 a1">
			<input id="txtDniC" class="stext-111 cl8 plh3 size-111 p-lr-15" type="number" name="txtDniC" maxlength="8" placeholder="N° de DNI">
			<input type="hidden" id="nombreobtenido" >
		</div>
		<div class="bor8 bg0 m-b-12 a6">
			<input id="txtEmailC" class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="txtEmailC" placeholder="Correo Electrónico">
		</div>
			
			`
		$("#reg_add").html(html_tipo_reg);
		document.querySelector("#txtnewoexist").value = "exist";
		document.querySelector("#exist").classList.remove("buttonconfirm");
		document.querySelector("#exist").classList.add("buttonconfirmSeleccionado");
		document.querySelector("#new").classList.remove("buttonconfirmSeleccionado");
		document.querySelector("#new").classList.add("buttonconfirm");
		
		document.querySelector("#showrpta").style.display = "block";
		buscarDNI();
	}
	

}
// BUSCAR CLIENTE REGISTRADO
function buscarDNI(){
	$("#txtDniC").on("change",function () {
		let dni = this.value;
		
		divLoading.style.display = "flex";
		let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
		let ajaxUrl = base_url+'/Tienda/getClienteNombre';
		let formData = new FormData();
		formData.append('dni',dni); 
		request.open("POST",ajaxUrl,true);
		request.send(formData);
		request.onreadystatechange = function(){
			if(request.readyState != 4) return;
			if(request.status == 200){
				let objData = JSON.parse(request.responseText);
				
				if(objData.status)
				{
					document.querySelector("#nombreobtenido").value = objData.data.nombre;
					// document.querySelector("#txtCelularC").value = objData.data.celular;
					document.querySelector("#txtEmailC").value = objData.data.correo;
					// document.querySelector("#txtCiudadC").value = objData.data.ciudad;
					// document.querySelector("#txtAdicional").value = objData.data.adicional;
					
					const Toast = Swal.mixin({
						toast: true,
						position: 'top-end',
						showConfirmButton: false,
						timer: 3000,
						timerProgressBar: true,
						didOpen: (toast) => {
						  toast.addEventListener('mouseenter', Swal.stopTimer)
						  toast.addEventListener('mouseleave', Swal.resumeTimer)
						}
					  })
					  
					Toast.fire({
						icon: 'success',
						title: objData.data.nombre+' bienvenid@ nuevamente'
					})
					document.querySelector("#btnCompraTotal").setAttribute("estatusRegistro","1"); //Ya está registrado
					document.querySelector("#btnCompraTotal").setAttribute("regClienteId",objData.data.id_cliente);
	
				}else{
					// document.querySelector("#txtNombreC").value = "";
					// document.querySelector("#txtCelularC").value = "";
					// document.querySelector("#txtDireccionC").value = "";
					// document.querySelector("#txtCiudadC").value = "";
					// document.querySelector("#txtAdicional").value = "";
					const Toast = Swal.mixin({
						toast: true,
						position: 'top-end',
						showConfirmButton: false,
						timer: 3000,
						timerProgressBar: true,
						didOpen: (toast) => {
						  toast.addEventListener('mouseenter', Swal.stopTimer)
						  toast.addEventListener('mouseleave', Swal.resumeTimer)
						}
					  })
					  
					Toast.fire({
						icon: 'error',
						title: 'No existe registro con este DNI'
					})
					
					// document.getElementById('txtNombreC').value = "";
					document.getElementById('txtDniC').value = "";
					document.querySelector("#nombreobtenido").value = "";
					document.querySelector("#btnCompraTotal").setAttribute("estatusRegistro","0"); //No está registrado
					document.querySelector("#btnCompraTotal").setAttribute("regClienteId","");
	
	
				}
			}
			divLoading.style.display = "none";
			return false;
		}
	
	})
}

// ÚLTIMO REGISTRO
if(document.querySelector("#btnCompraTotal")){
	let btnPagoTotal = document.querySelector("#btnCompraTotal");
	btnPagoTotal.addEventListener('click',function() {
		
		var rg_tipoRegistroUsuarios = document.querySelector("#txtnewoexist").value;
		var rg_dni = document.querySelector("#txtDniC").value;
	    var rg_inttipopago = document.querySelector("#listtipopago").value; 
		var rg_adicional = document.querySelector("#txtAdicional").value;
		var rg_numorden = document.querySelector("#btnCompraTotal").getAttribute("numorden");
		var rg_estado_registro = document.querySelector("#btnCompraTotal").getAttribute("estatusregistro"); //Nuevo o existente
		var rg_correo = document.querySelector("#txtEmailC").value;

		

		if(rg_tipoRegistroUsuarios == "new"){
			var rg_nombre = document.querySelector("#txtNombreC").value;
			var rg_celular = document.querySelector("#txtCelularC").value;
			var rg_direccion = document.querySelector("#txtDireccionC").value;
			if(rg_dni == '' || rg_nombre == '' || rg_celular == '' || rg_inttipopago =="" || rg_correo =="")
			{

				const Toast = Swal.mixin({
					toast: true,
					position: 'top-end',
					showConfirmButton: false,
					timer: 3000,
					timerProgressBar: true,
					didOpen: (toast) => {
						toast.addEventListener('mouseenter', Swal.stopTimer)
						toast.addEventListener('mouseleave', Swal.resumeTimer)
					}
				})
				
				Toast.fire({
					icon: 'info',
					title: 'Hay campos que son obligatorios.'
				})
				return false;
			}
		}
		if(rg_tipoRegistroUsuarios == "exist"){
			var rg_idClienteRegistrado = document.querySelector("#btnCompraTotal").getAttribute("regClienteId");
			var rg_nombreobtenido = document.querySelector("#nombreobtenido").value;
			if(rg_dni == '' || rg_inttipopago =="" || rg_correo =="")
			{

				const Toast = Swal.mixin({
					toast: true,
					position: 'top-end',
					showConfirmButton: false,
					timer: 3000,
					timerProgressBar: true,
					didOpen: (toast) => {
						toast.addEventListener('mouseenter', Swal.stopTimer)
						toast.addEventListener('mouseleave', Swal.resumeTimer)
					}
				})
				
				Toast.fire({
					icon: 'info',
					title: 'Hay campos que son obligatorios.'
				})
				return false;
			}
		}

		divLoading.style.display = "flex";

		let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
		let ajaxUrl = base_url+'/Tienda/procesarDatosCliente';
		let formData = new FormData();
		if(rg_tipoRegistroUsuarios == "new")
		{
			formData.append('tipo_registro_usuario',rg_tipoRegistroUsuarios);
			formData.append('dni',rg_dni);
			formData.append('nombre',rg_nombre);
			formData.append('celular',rg_celular); 
			formData.append('correo',rg_correo); 
			formData.append('adicional',rg_adicional); 
			formData.append('direccion',rg_direccion); 
			formData.append('numorden',rg_numorden); 
			formData.append('inttipopago',rg_inttipopago); 
			formData.append('estado_registro',rg_estado_registro); 

		}
		if(rg_tipoRegistroUsuarios == "exist")
		{
			formData.append('tipo_registro_usuario',rg_tipoRegistroUsuarios);
			formData.append('dni',rg_dni);
			formData.append('adicional',rg_adicional); 
			formData.append('numorden',rg_numorden); 
			formData.append('inttipopago',rg_inttipopago); 
			formData.append('correo',rg_correo); 
			formData.append('nombreobtenido',rg_nombreobtenido); 
			formData.append('estado_registro',rg_estado_registro); 
			formData.append('idclienteregistrado',rg_idClienteRegistrado); 
		} 
		request.open("POST",ajaxUrl,true);
		request.send(formData);
		request.onreadystatechange = function(){
			if(request.readyState != 4) return;
			if(request.status == 200){
				let objData = JSON.parse(request.responseText);
			
				if(objData.status){
					window.location = base_url+"/tienda/confirmarpedido/";
				}else{
					Swal.fire({
						position: 'top-center',
						icon: 'error',
						title: objData.msg,
						showConfirmButton: false,
						timer: 1500
					  })
				}
			}
			divLoading.style.display = "none";
			return false;
		}


	},false);
}

//REFERIDOS
function referidos(clt,nom) {

	if(clt != "" || clt != NULL || nom != "" || nom != NULL) {
		$("#rf_clt").val(clt);
		$("#rf_nomb").val(nom);
		$('#modalReferidos').modal("show")

	}
}

if(document.querySelector("#formRegisterReferides")){
    let formRegisterReferides = document.querySelector("#formRegisterReferides");
    formRegisterReferides.onsubmit = function(e) {
        e.preventDefault();
        let strNombre = document.querySelector('#rf_nombre').value;
        let strCelular = document.querySelector('#rf_celular').value;
        let strEmail = document.querySelector('#rf_email').value;
        let intIdCliente = document.querySelector('#rf_clt').value;
        let strNombreCliente = document.querySelector('#rf_nomb').value;
	  	

	

		if(!fntEmailValidate(strEmail)){
			const Toast = Swal.mixin({
				toast: true,
				position: 'top-end',
				showConfirmButton: false,
				timer: 3000,
				timerProgressBar: true,
				didOpen: (toast) => {
					toast.addEventListener('mouseenter', Swal.stopTimer)
					toast.addEventListener('mouseleave', Swal.resumeTimer)
				}
			})

			Toast.fire({
				icon: 'warning',
				title: 'El email no es válido.'
			})
			return false;
		}
		if(!verificarNumCel(strCelular)){
			const Toast = Swal.mixin({
				toast: true,
				position: 'top-end',
				showConfirmButton: false,
				timer: 3000,
				timerProgressBar: true,
				didOpen: (toast) => {
					toast.addEventListener('mouseenter', Swal.stopTimer)
					toast.addEventListener('mouseleave', Swal.resumeTimer)
				}
			})

			Toast.fire({
				icon: 'warning',
				title: 'N° Celular incorrectos.'
			})
			return false;
		}
		
		divLoading.style.display = "flex";
		let request = (window.XMLHttpRequest) ? 
                    new XMLHttpRequest() : 
                    new ActiveXObject('Microsoft.XMLHTTP');
		let ajaxUrl = base_url+'/Tienda/referidos';
		let formData = new FormData(formRegisterReferides);
	   	request.open("POST",ajaxUrl,true);
	    request.send(formData);
	    request.onreadystatechange = function(){
	    	if(request.readyState != 4) return;
	    	if(request.status == 200){
	    		let objData = JSON.parse(request.responseText);
	    		if(objData.status){
					

					Swal.fire({
						title: objData.msg,
						html:'<i class="fas fa-hand-o-right"></i> Una vez validemos tu registro, te enviaremos un <b>cupón de descuento</b>',
						icon: 'success',
						// imageAlt: 'Custom image',
						showCloseButton: true,
						showCancelButton: false,
						focusConfirm: false,
						confirmButtonText:
							'<i class="fa fa-thumbs-up"></i>',
						confirmButtonAriaLabel: 'Thumbs up, great!',
					})



					$('#modalReferidos').modal("hide")
					

                	document.querySelector("#formRegisterReferides").reset();
	    		}else{
					const Toast = Swal.mixin({
						toast: true,
						position: 'top-end',
						showConfirmButton: false,
						timer: 3000,
						timerProgressBar: true,
						didOpen: (toast) => {
						  toast.addEventListener('mouseenter', Swal.stopTimer)
						  toast.addEventListener('mouseleave', Swal.resumeTimer)
						}
					  })
					  
					  Toast.fire({
						icon: 'error',
						title: objData.msg
					  })
	    		}
	    	}
	    	divLoading.style.display = "none";
        	return false;
		}

    }
}