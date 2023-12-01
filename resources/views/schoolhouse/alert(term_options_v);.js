        alert(term_options_v);
        alert(term_values_v);


        function createAssociativeArray(arr1, arr2) {
            var arr = new Object();
            for(var i = 0, ii = arr1.length; i<ii; i++) {
                arr[arr1[i]] = arr2[i];
            }
            return arr;
        }

        function getObjectPropertiesLength(obj) {
            var propNum = 0;
            for(prop in obj) {
                if(obj.hasOwnProperty(prop)) propNum++;
            }
            return propNum;
        }

        // var p = getObjectPropertiesLength(associativeArray);

        var associativeArray = createAssociativeArray(term_options_v, term_values_v);

        const keys = Object.getOwnPropertyNames(associativeArray);

        console.log("Keys are listed below ");

        // Display output
        console.log(Object.values(associativeArray));
        console.log(Object.keys(associativeArray));
        //var sessioncount = Object.keys(associativeArray).length;
                    let res = document.getElementById('updatesessionid');


                    <select id="arr">
                    <option>Dropdown Items</option>
                </select>
                <br><br>

                <button onclick="GFG_Fun();">
                    Click Here
                </button>

                <h2 id="GFG" style="color: green;"></h2>

                <script>
                    let res = document.getElementById('GFG');
                    let select = document.getElementById("arr");
                    let elmts = ["HTML", "CSS", "JS", "PHP", "jQuery"];

                    // Main function
                    function GFG_Fun() {
                        for (let i = 0; i < elmts.length; i++) {
                            let optn = elmts[i];
                            let el = document.createElement("option");
                            el.textContent = optn;
                            el.value = optn;
                            select.appendChild(el);
                        }
                        res.innerHTML = "Elements Added";
                    }
                </script>
            </div>
