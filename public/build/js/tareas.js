document.querySelector("#agregar-tarea").addEventListener("click",(function(){const e=document.createElement("DIV");e.classList.add("modal"),e.innerHTML='\n           <form class="formulario nueva-tarea">\n                <legend>Añade una nueva tarea</legend>\n\n                <div class="campo">\n                    <label>Tarea</label>\n                    <input type="text" name="tarea" placeholder="Añadir Tarea al Proyecto Actual" id="tarea">\n\n                </div>\n\n                <div class="opciones">\n                    <input type="submit"\n                    class="submit-nueva-tarea"\n                    value="Añadir Tarea">\n                    <button type="button" class="cerrar-modal">Cancelar</button>\n                </div>\n                        \n            </form>\n        ',setTimeout(()=>{document.querySelector(".formulario").classList.add("animar")},0),e.addEventListener("click",(function(a){a.preventDefault,a.target.classList.contains("cerrar-modal")&&(document.querySelector(".formulario").classList.add("cerrar"),setTimeout(()=>{e.remove()},1500))})),document.querySelector(".dashboard").appendChild(e)}));