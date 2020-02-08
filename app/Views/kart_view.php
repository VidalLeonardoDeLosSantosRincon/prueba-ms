
    <title>Saved</title>
    <div id="ctr-products">
        <div id="all_products">
        </div>
    </div>

    <script>
        (function(){
            function getSavedProduct(){
                let template="";
                let boxPro = document.getElementById("all_products");
                
                fetch("http://localhost/mediasoft/index.php/product/get")
                .then((res)=>res.text())
                .then((res)=>{
                    let products_saved = JSON.parse(res.substring(0,res.lastIndexOf("}")+1));
                    //console.log(products_saved);
                    products_saved["products"].reverse().map((product)=>{
                        template +=`<div class="product">
                                <img class="image_product" id="image" name="${product.code_id}" src=${product.image} alt=image_${product.code_id} />
                                <h4 id="name">${product.name}</h4>
                                <h4 id="status">${product.status}</h4>
                                <h4 id="category">Category:${product.category}</h4>
                                <h4 id="condition">Condition:${product.condicion}</h4>
                                <h4 id="color">Color:${product.color}</h4>
                                <h4 id="size">Size:${product.size}</h4>
                                <h4 id="occasion">Occasion:${product.occasion}</h4>
                                <h4 id="gender">Gender:${product.gender}</h4>
                                <h4 id="code">code: ${product.code_id}</h4>
                                <p id="description">Description:${product.description}</p>
                                <button class="remove_from_kart" name="btn_${product.id}">remove</button>
                            </div>`;
                    });

            
                    
                //appending template to body
                boxPro.innerHTML = template;

                //adding events to add to kart
                let deleteButtons = Array.from(document.getElementsByClassName("remove_from_kart"));
                    deleteButtons.map((deleteButton)=>{
                        deleteButton.addEventListener("click",removeFromKart);
                    })

                /**/////////////////////////setting image product//////////////////// */
                if(localStorage.getItem("products")!==null){
                        let products_storage = JSON.parse(localStorage.getItem("products"));
                        let images_products = Array.from(document.getElementsByClassName("image_product"));

                        images_products.map((image)=>{
                            
                            products_storage.map((product)=>{
                                if(parseInt(image.name)===product.code_id){
                                    image.src = product.image;
                                }
                            });

                        })
                }
                /**////////////////////////////////////////////////////////////// */
                }).catch((er)=>console.log(er))
            }
            getSavedProduct();


            function removeFromKart(e){
                let id = e.target.name.substring(e.target.name.trim().indexOf("_")+1,e.target.name.trim().length)
                let xhr = new XMLHttpRequest();
                        xhr.onreadystatechange = function() 
                        {
                            if (xhr.readyState == 4 && xhr.status == 200) 
                            {
                                let response = xhr.responseText;
                                response = JSON.parse(response.substring(0,response.indexOf("<")));
                                console.log(response);
                                
                                if(response===true){
                                    alert("Product was deleted");
                                    location.reload();
                                }else if(response===false){
                                    alert("Product wasn't deleted");
                                }
                            }
                        };

                        xhr.open("POST", "http://localhost/mediasoft/index.php/product/delete?", true);
                        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                        xhr.send(`id=${id}`);
            }

        })();
    </script>
    <style id="saved_styles">

        #ctr-products{
            background:white;
            padding:25px 30px;
            box-sizing:border-box;

        }

        #ctr-products #search-box{
            background:white;
            height:50px;
            padding:10px 25px;
            box-sizing:border-box;

            display:flex;
            justify-content:center;
            align-items:center;
        }

        #ctr-products #search-box span{
            background:white;
            width:410px;
            display:flex;
            justify-content:center;
            align-items:center;
            padding:5px;
            box-sizing:border-box;
        }

        #ctr-products #search-input{
            height:30px;
            width:80%;
            padding:5px 10px;
            box-sizing:border-box;
            border:1px solid rgba(0,0,0,0.1);
            border-radius:3px 0 0 3px;
            color:gray;
        }

        #ctr-products #search-btn{
            height:30px;
            width:20%;
            cursor:pointer;
            background:dodgerblue;
            color:white;
            border:none;
            border-radius:0 3px 3px 0;
        }


        #ctr-products #all_products{
            margin:50px 0 0 0;
            width:100%;
            background:white;
            padding:5px;
            box-sizing:border-box;
            
            display:flex;
            flex-wrap:wrap;
            justify-content:flex-start;
        }
        #ctr-products #all_products .product{
            background:white;
            width:320px;
            padding:10px;
            box-sizing:border-box;
            border-radius:3px;
            box-shadow:1px 2px 5px rgba(0,0,0,0.1);
            margin:5px;
            border:1px solid rgba(0,0,0,0.1);
        }

        #ctr-products #all_products .product:hover{
            box-shadow:1px 10px 5px rgba(0,0,0,0.1);
            transform:translateY(-5px);
        }

        #ctr-products #all_products .product #image{
            width:100%;
            height:250px;
        }

        #ctr-products #all_products .product #image:hover{
            transform:scale(1.3);
            box-shadow:2px 10px 5px rgba(0,0,0,0.2);
            border-radius:5px;
            border:1px solid dodgerblue;
        }


        #ctr-products #all_products .product #name{
            font-size:25px;
            font-weight:300;
            color:gray;
        }

        #ctr-products #all_products .product #status{
            font-size:14px;
            font-weight:300;
            padding:5px;
            width:80px;
            background:dodgerblue;
            border-radius:3px;
            color:white;
        }
        #ctr-products #all_products .product #category{
            font-size:14px;
            font-weight:300;
            color:gray;
        }
        #ctr-products #all_products .product #condition{
            font-size:14px;
            font-weight:300;
            color:gray;
        }

        #ctr-products #all_products .product #color{
            font-size:14px;
            font-weight:300;
            color:gray;
        }

        #ctr-products #all_products .product #size{
            font-size:14px;
            font-weight:300;
            color:gray;
        }

        #ctr-products #all_products .product #occasion{
            font-size:14px;
            font-weight:300;
            color:gray;
        }

        #ctr-products #all_products .product #gender{
            font-size:14px;
            font-weight:300;
            color:gray;
        }

        #ctr-products #all_products .product #code{
            font-size:14px;
            font-weight:300;
            color:gray;
        }

        #ctr-products #all_products .product #description{
            font-size:12px;
            font-weight:300;
            color:gray;
        }

        #ctr-products #all_products .product .remove_from_kart{
            border:none;
            border-radius:3px;
            color:lightseagreen;
            background:rgba(0,0,0,0.04);
            width:100%;
            margin:5px 0 0 0;
            padding:5px 20px;
            box-sizing:border-box;
            cursor:pointer;
        }


        
        #ctr-products #all_products .product .remove_from_kart:hover{
            background:rgba(0,0,0,0.06);
            
        }
    </style>
