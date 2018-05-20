let selectFunc = document.getElementById("selectFunc");
let createTb = document.getElementById("createTb");
let colNum = document.getElementById("colNum");
let commit = document.getElementById("commit");
let selectTb = document.getElementById("selectTb");
let name = document.getElementById("name");
let table = document.getElementById("table");
let addRow = document.getElementById("addRow");
let deleteRow = document.getElementById("deleteRow");
let sure = document.getElementById("sure");
let tables = [];

function Table() {
	this.tbName = "";
	this.col = 0;
	this.row = 0;
	this.cont = [];
}

function com(temp) {
	switch(selectFunc.value) {
		case "Create Table": selectTb.classList.remove("non"); addOption(); newTb(); break;
		case "Add Row": newRow(); break;
		case "Delete Row": delRow(); break;
		case "Delete Table": delTb(); break;
	}
}

function changeFunc() {
	switch(selectFunc.value) {
		case "Select One": sure.style.display="none";createTb.classList.remove("non");break;
		case "Create Table": sure.style.display="none";refresh(0);break;
		case "Add Row": sure.style.display="none";getCont();break;
		case "Delete Row": sure.style.display="none";getCont();break;
		case "Delete Table": warning();break;
	}
}

function setATTR() {
	let i = document.getElementById("colNum").value;
	let oldCol = document.getElementsByClassName("ATTR");
	let oldColNum = oldCol.length;
	if(i != 0)
		commit.classList.remove("non");
	else
		commit.style.display = "none";
	if(i > oldColNum) {
		for(let n=0; n<i-oldColNum; n++) {
			let input = document.createElement("input");
			input.placeholder = "Attr";
			input.classList.add("ATTR");
			createTb.appendChild(input);
		}
	}
	if(i < oldColNum) {
		for(let n=0; n<oldColNum-i; n++)
			createTb.removeChild(oldCol[0]);
	}
}

function addOption() {
	let option = document.createElement("option");
	let n = document.createTextNode(name.value);
	option.appendChild(n);
	selectTb.appendChild(option);
	let opt = selectTb.children;
	for(let i=0; i<opt.length; i++) {
		if(opt[i].value == name.value) {
			opt[i].selected = true;
		}
	}
}

function newTb() {
	let numOfCol = document.getElementById("colNum").value;
	var tempTb = new Table();
	tempTb.tbName = name.value;
	tempTb.row = 1;
	tempTb.col = colNum.value;
	let tempATTR = [];
	for(let i=0; i<numOfCol; i++)
		tempATTR[i] = document.getElementsByClassName("ATTR")[i].value;
	tempTb.cont[0] = tempATTR;
	addTb(tempTb);
	let count = tables.push(tempTb);
}

function addTb(o) {
	table.classList.remove("non");
	while(table.hasChildNodes())
		table.removeChild(table.firstChild);
	for(let i=0; i<o.row; i++) {
		let tr = document.createElement("tr");
		if(i%2 == 0)
			tr.classList.add("odd");
		table.appendChild(tr);
		for(let j=0; j<o.col; j++) {
			if(i == 0) {
				let td = document.createElement("th");
				td.innerHTML=o.cont[i][j];
				tr.appendChild(td);
			}
			else {
				let td = document.createElement("td");
				td.innerHTML=o.cont[i][j];
				tr.appendChild(td);
			}
		}
	}
}

function getCont() {
	refresh(1);
	while(addRow.hasChildNodes())
		addRow.removeChild(addRow.firstChild);
	let tbSel = selectTb.value;
	let tbNow;
	for(let i=0; i<tables.length; i++) {
		if(tables[i].tbName == tbSel)
			tbNow = tables[i];
	}
	for(let i=0; i<tbNow.cont[0].length; i++) {
		let attrProp = document.createElement("input");
		attrProp.placeholder = tbNow.cont[0][i];
		attrProp.classList.add("isProp");
		addRow.appendChild(attrProp);
	}
}

function newRow(){
	let tbSel = selectTb.value;
	let tbNow;
	for(let i=0; i<tables.length; i++)  {
		if(tables[i].tbName == tbSel)
			tbNow = tables[i];
	}
	let tempATTR = [];
	for(let i=0; i<tbNow.col; i++)
		tempATTR[i] = document.getElementsByClassName("isProp")[i].value;
	tbNow.cont.push(tempATTR);
	tbNow.row++;
	addTb(tbNow);
}

function delRow() {
	let ruler = document.getElementsByClassName("isProp");
	let tbSel = selectTb.value;
	let tbNow;
	for(let i=0; i<tables.length; i++) {
		if(tables[i].tbName == tbSel)
			tbNow = tables[i];
	}
	let prep = [];
	for(let i=1; i<tbNow.cont.length; i++) {
		let match = true;
		for(let j=0; j<tbNow.cont[i].length; j++){
			if(tbNow.cont[i][j] != ruler[j].value){
				match = false;
				break;
			}
		}
		if(match)
			prep.push(i);
	}
	for(let i=0; i<prep.length; i++)
		tbNow.cont.splice(prep[i],1);
	addTb(tbNow);
}

function delTb() {
	let tbSel = selectTb.value;
	let tbNow;
	for(let i=0; i<tables.length; i++) {
		if(tables[i].tbName == tbSel) {
			tbNow = tables[i];
			tables.splice(i,1);
			let opt = selectTb.children;
			for(let j=0; j<opt.length; j++) {
				if(opt[j].value == tbNow.tbName) {
					selectTb.removeChild(opt[j]);
					if(tables.length != 0)
						opt[1].selected = true;
					else
						opt[0].selected = true;
				}
			}
		}
	}
	if(tables.length != 0)
		addTb(tables[0]);
	else {
		alert("It is empty!");
		table.classList.remove("non");
		while(table.hasChildNodes())
			table.removeChild(table.firstChild);
	}
}

function show() {
	let tbSel = selectTb.value;
	let tbNow;
	for(let i=0; i<tables.length; i++) {
		if(tables[i].tbName == tbSel)
			tbNow = tables[i];
	}
	if(tbNow != undefined)
		addTb(tbNow);
}



function warning() {
	sure.style.display = "block";
}

function refresh(n) {
	switch(n) {
		case 0:
			createTb.style.display = "block";
			addRow.style.display = "none";
			deleteRow.style.display = "none";
			break;
		case 1:
			createTb.style.display = "none";
			addRow.style.display = "block";	
			deleteRow.style.display = "none";
			break;
	}
}














