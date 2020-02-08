
    <title>Products</title>
    <div id="ctr-products">

        <div id="search-box">
            <span>
                <input  type="text" id="search-input" name="search-input" placeholder="search"/>
                <input type="button" id="search-btn" value="Search"/>
            </span>
        </div>

        <div id="all_products">

        </div>
    </div>

    <script>
        (function(){
      
            function getData(){    
                let template=""; 
                let boxPro = document.getElementById("all_products");
                const products =[];
                        
                fetch("https://pos.ricobot.com/catalogs/")
                .then(res=>res.json())
                .then(res=>{
                    //console.log(res);
                    if(Array.isArray(res.results)){
                        res.results.reverse().map((result)=>{
                            //console.log(result);

                            let product = {  
                                code_id:result.id,
                                image: result.images[0].image,
                                name: result.name,
                                status: result.status.name,
                                category: result.category.name,
                                condition: result.condition,
                                color: result.color.name,
                                size: result.sizes[0].name,
                                occasion: result.occasion.name,
                                gender: result.gender,
                                description: result.description
                            }

                            products.push(product);
                        template +=`
                            <div class="product">
                                <img id="image" src=${result.images[0].image} alt=image_${result.name} />
                                <h4 id="name">${result.name}</h4>
                                <h4 id="status">${result.status.name}</h4>
                                <h4 id="category">Category:${result.category.name}</h4>
                                <h4 id="condition">Condition:${result.condition}</h4>
                                <h4 id="color">Color:${result.color.name}</h4>
                                <h4 id="size">Size:${result.sizes[0].name}</h4>
                                <h4 id="occasion">Occasion:${result.occasion.name}</h4>
                                <h4 id="gender">Gender:${result.gender}</h4>
                                <p id="description">Description:${result.description}</p>
                                <button class="add_to_kart" name="${result.id}">Add</button>
                            </div>`;

                          
                        })
                        
                        //saving date on localStorage
                        localStorage.setItem("products_ms",JSON.stringify(products));
                     
                        //appending template to body
                        boxPro.innerHTML = template;

                         //adding events to add to kart
                        let addButtons = Array.from(document.getElementsByClassName("add_to_kart"));
                        addButtons.map((addButton)=>{
                            addButton.addEventListener("click",addToKart);
                        })                   }
                }).catch(er=>console.log(er));
            }
            getData();


            let searchBtn = document.getElementById("search-btn");
            function searchProduct(){
                let template=""; 
                const products =[];
                let boxPro = document.getElementById("all_products");
                let searchInput = document.getElementById("search-input").value.trim();
                if(searchInput!==""){
                    fetch(`https://pos.ricobot.com/catalogs/?&search=${searchInput}`)
                    .then(res=>res.json())
                    .then(res=>{
                        if(res.count===0){
                            template +=`
                                    <div id="no-results">
                                        <h5>No results</h5>
                                        <a href="http://localhost/mediasoft/index.php/product">Go back</a>
                                    </div>`;
                            boxPro.innerHTML = template;
                        }else{
                            if(Array.isArray(res.results)){
                                res.results.map((result)=>{
                                   // console.log(result);

                                        
                                let product = {  
                                    code_id:result.id,
                                    image: result.images[0].image,
                                    name: result.name,
                                    status: result.status.name,
                                    category: result.category.name,
                                    condition: result.condition,
                                    color: result.color.name,
                                    size: result.sizes[0].name,
                                    occasion: result.occasion.name,
                                    gender: result.gender,
                                    description: result.description
                                }

                                products.push(product);

                                template +=`
                                    <div class="product">
                                        <img id="image" src=${result.images[0].image} alt=image_${result.name} />
                                        <h4 id="name">${result.name}</h4>
                                        <h4 id="status">${result.status.name}</h4>
                                        <h4 id="condition">Category:${result.category.name}</h4>
                                        <h4 id="condition">Condition:${result.condition}</h4>
                                        <h4 id="color">Color:${result.color.name}</h4>
                                        <h4 id="size">Size:${result.sizes[0].name}</h4>
                                        <h4 id="occasion">Occasion:${result.occasion.name}</h4>
                                        <h4 id="gender">Gender:${result.gender}</h4>
                                        <p id="description">Description:${result.description}</p>
                                        <button class="add_to_kart" name="${result.id}">Add</button>
                                    </div>`;
                                })
                                //saving date on localStorage
                                localStorage.setItem("products_ms",JSON.stringify(products));
                                
                                //appending template to body
                                boxPro.innerHTML = template;   
                                
                                //adding events to add to kart
                                let addButtons = Array.from(document.getElementsByClassName("add_to_kart"));
                                addButtons.map((addButton)=>{
                                    addButton.addEventListener("click",addToKart);
                                })

                            }
                        }
                    }).catch(er=>console.log(er));
                }else{
                    alert("Empty fields are not allowed");
                }
            }
            searchBtn.addEventListener("click",searchProduct);

            
            function addToKart(e){

                if(localStorage.getItem("products_ms")!==null){
                    let products_storage = JSON.parse(localStorage.getItem("products_ms"));
                    let data_to_add ={};

                    
                    products_storage.map((product)=>{
                        if(parseInt(e.target.name)===product.code_id){
                            data_to_add = product;
                        }
                    });
                    if(data_to_add.code_id){
                        let xhr = new XMLHttpRequest();
                        xhr.onreadystatechange = function() 
                        {
                            if (xhr.readyState == 4 && xhr.status == 200) 
                            {
                                let response = xhr.responseText;
                                response = JSON.parse(response.substring(0,response.indexOf("<")));
                                if(response===true){
                                    alert("Product was saved");
                                    localStorage.setItem(`savedProduct_${data_to_add.code_id}`,JSON.stringify(data_to_add));
                                }else if(response===false){
                                    alert("Product wasn't saved");
                                }
                            }
                        };

                        const {
                            code_id, 
                            image, 
                            name, 
                            status, 
                            category, 
                            condition, 
                            color, 
                            size, 
                            occasion, 
                            gender,
                            description} = data_to_add;
                        xhr.open("POST", "http://localhost/mediasoft/index.php/product/add?", true);
                        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                        xhr.send(`code_id=${code_id}&image=${image}&name=${name}&status=${status}&category=${category}&condition=${condition}
                        &color=${color}&size=${size}&occasion=${occasion}&gender=${gender}&description=${description}`);
                        
                    }
                }
            }
        })();

    </script>

    <style id="product_styles">
        
        #ctr-products{
            background:white;
            padding:25px 10px;
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
            justify-content:center;
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

        #ctr-products #all_products .product #description{
            font-size:12px;
            font-weight:300;
            color:gray;
        }

        #ctr-products #all_products .product .add_to_kart{
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


        
        #ctr-products #all_products .product .add_to_kart:hover{
            background:rgba(0,0,0,0.06);
            
        }

        #no-results{
            height:100vh;
            width:100%;
            display:flex;
            flex-direction:column;
            align-items:center;

        }

        #no-results h5{
            font-size:30px;
            font-weight:300;
            color:gray;
            
        }

        #no-results a{
            text-decoration:none;
            color:white;
            background:dodgerblue;
            padding:5px 25px;
            border:none;
            border-radius:3px;
            box-sizing:border-box;
            margin:5px 0 0 0;
            
        }

    </style>
