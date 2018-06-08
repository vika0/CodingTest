/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var real_id = 0;

function addSubCategory(level, id, parentId, element) {
    
    var myDiv = document.createElement("div");
    myDiv.className = "level-" + level;
    var btn = document.createElement("input");
    btn.type = "button";
    btn.name = "addSubCategory";
    btn.value = "Add sub-category";
    btn.addEventListener("click", function (event) {
        addSubCategory(level + 1, real_id + 1, id, event.target.parentNode);
    });
    real_id++;

    var HiddenBtn = document.createElement("input");
    HiddenBtn.type = "hidden";
    HiddenBtn.name = "category-id[]";
    HiddenBtn.value = real_id;
    var HiddenBtn1 = document.createElement("input");
    HiddenBtn1.type = "hidden";
    HiddenBtn1.name = "category-parent[]";
    HiddenBtn1.value = parentId;
    var textBox = document.createElement("input");
    textBox.type = "text";
    textBox.name = "category-title[]";
    if (level === 0)
        var placeholder = "Category title";
    else
        var placeholder = "Sub-Category title";
    textBox.placeholder = placeholder;
    myDiv.appendChild(textBox);
    myDiv.appendChild(btn);
    myDiv.appendChild(HiddenBtn);
    myDiv.appendChild(HiddenBtn1);
    if (level > 0) {
        var rmBtn = document.createElement("input");
        rmBtn.type = "button";
        rmBtn.value = "Remove";
        rmBtn.addEventListener("click", function (event) {
            event.target.parentNode.remove();
        });
        myDiv.appendChild(rmBtn);
    }
    element.appendChild(myDiv);
}

addSubCategory(0, 1, 0, document.querySelector('.input_fields_wrap'));

