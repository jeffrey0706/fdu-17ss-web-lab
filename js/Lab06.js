function insert(nodeParentId, nodeType, newHTML, newId) {
 let nodeParent = "";
 if( nodeParentId != null)
  nodeParent = document.getElementById(nodeParentId);
 else
  nodeParent = document.getElementById("div1");
 let newNode = document.createElement(nodeType);
 if( newHTML != null)
  newNode.innerHTML = newHTML + "";
 if( newId != null)
  newNode.id = newId + "";
 nodeParent.appendChild(newNode);
}



let tempHTML = "";



// FIRST ITEM
tempHTML = "<h2>Canada</h2>\
            <p>North America</p>";
insert("div1", "div", tempHTML, "div2");
document.getElementById("div2").className = "item";
tempHTML = "<h3>Cities</h3>\
            <li>Calgary</li>\
            <li>Montreal</li>\
            <li>Toronto</li>";
insert("div2", "ul", tempHTML, "ul1");
document.getElementById("ul1").className = "inner-box";
tempHTML = "<h3>Popular Photos</h3>\
            <img src='./images/canada1.jpg' class='photo'>\
            <img src='./images/canada2.jpg' class='photo'>\
            <img src='./images/canada3.jpg' class='photo'>";
insert("div2", "div", tempHTML, "divP1");
document.getElementById("divP1").className = "inner-box";
tempHTML = "View";
insert("div2", "button", tempHTML, null);



// SECOND ITEM
tempHTML = "<h2>United States</h2>\
            <p>North America</p>";
insert("div1", "div", tempHTML, "div3");
document.getElementById("div3").className = "item";
tempHTML = "<h3>Cities</h3>\
            <li>Boston</li>\
            <li>Chicago</li>\
            <li>New York</li>\
            <li>Seattle</li>\
            <li>Washington</li>";
insert("div3", "ul", tempHTML, "ul2");
document.getElementById("ul2").className = "inner-box";
tempHTML = "<h3>Popular Photos</h3>\
            <img src='./images/us1.jpg' class='photo'>\
            <img src='./images/us2.jpg' class='photo'>";
insert("div3", "div", tempHTML, "divP2");
document.getElementById("divP2").className = "inner-box";
tempHTML = "View";
insert("div3", "button", tempHTML, null);



// THIRD ITEM
tempHTML = "<h2>Italy</h2>\
            <p>Europe</p>";
insert("div1", "div", tempHTML, "div4");
document.getElementById("div4").className = "item";
tempHTML = "<h3>Cities</h3>\
            <li>Florence</li>\
            <li>Milan</li>\
            <li>Naples</li>\
            <li>Rome</li>";
insert("div4", "ul", tempHTML, "ul3");
document.getElementById("ul3").className = "inner-box";
tempHTML = "<h3>Popular Photos</h3>\
            <img src='./images/italy1.jpg' class='photo'>\
            <img src='./images/italy2.jpg' class='photo'>\
            <img src='./images/italy3.jpg' class='photo'>\
            <img src='./images/italy4.jpg' class='photo'>\
            <img src='./images/italy5.jpg' class='photo'>\
            <img src='./images/italy6.jpg' class='photo'>";
insert("div4", "div", tempHTML, "divP3");
document.getElementById("divP3").className = "inner-box";
tempHTML = "View";
insert("div4", "button", tempHTML, null);



// FORTH ITEM
tempHTML = "<h2>Spain</h2>\
            <p>Europe</p>";
insert("div1", "div", tempHTML, "div5");
document.getElementById("div5").className = "item";
tempHTML = "<h3>Cities</h3>\
            <li>Almeria</li>\
            <li>Barcelona</li>\
            <li>Madrid</li>";
insert("div5", "ul", tempHTML, "ul4");
document.getElementById("ul4").className = "inner-box";
tempHTML = "<h3>Popular Photos</h3>\
            <img src='./images/spain1.jpg' class='photo'>\
            <img src='./images/spain2.jpg' class='photo'>";
insert("div5", "div", tempHTML, "divP4");
document.getElementById("divP4").className = "inner-box";
tempHTML = "View";
insert("div5", "button", tempHTML, null);