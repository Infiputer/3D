<canvas width="300" height="300" onclick = "createblock()">
  this da canvas 
</canvas>
<script>

var width = window.innerWidth - 20;
var height = window.innerHeight - 30;
const length = 400;
const canvas = document.querySelector('canvas');
canvas.width = width;
canvas.height = height;
canvas.onclick=function(){
	canvas.requestPointerLock();
	document.addEventListener("mousemove", moveMouse, false);
	createblock();
 };
function moveMouse(e){
	camdir += e.movementX/1000;
	camdir = camdir%(2*Math.PI);

	camdirz  += e.movementX/1000;
}
var ctx = canvas.getContext("2d");
dir = 90;
objects = [];
camx=width/2;
camy=height/2;
camz=0;
camdir=0;
camdirz = 0;
var camdir360 = 0;
class Player{
	constructor(x, y, z, color){
		this.x = x;
		this.y = y;
		this.z = z;
		this.color = color;
	}
	update(dir, cmx, cmy, cmz){
		this.diff = Math.abs(getAngleDifference(getAnglePoints(cmx, cmy, this.x, this.y), dir));
		//console.log({diff:getAnglePoints(cmx, cmy, this.x, this.y), dir:dir});
		ctx.fillStyle=(Math.random()<0.5)?"yellow":"orange";
		//rect(cmx, camy, 10, 10);
		//rect(cmx+Math.cos(dir-.68)*length, cmy+Math.sin(dir-.68)*length, 10, 10);
		//rect(cmx+Math.cos(dir+.68)*length, cmy+Math.sin(dir+.68)*length, 10, 10);
		if(isInside(
			cmx+Math.cos(dir-.68)*(length*2), cmy+Math.sin(dir-.68)*(length*2), 
			cmx+Math.cos(dir+.68)*(length*2), cmy+Math.sin(dir+.68)*(length*2),
			cmx, cmy, 
	  	this.x, this.y)){
			ctx.fillStyle = "green";
			this.distance = getDistance(this.x, this.y, cmx, cmy);
			for (this.linedir = -0.5333; this.linedir < 0.5333; this.linedir+=0.1) {
			//	ctx.beginPath();
			//	ctx.moveTo(cmx+Math.cos(dir+this.linedir)*this.distance, cmy+Math.sin(dir+this.linedir)*this.distance);
			//	ctx.lineTo(cmx+Math.cos(dir+this.linedir+0.1)*this.distance, cmy+Math.sin(dir+this.linedir+0.1)*this.distance);
			//	ctx.stroke();
			}
			
			//ctx.beginPath();
			//ctx.moveTo(cmx+Math.cos(dir-.68)*this.distance, cmy+Math.sin(dir-.68)*this.distance);
			//ctx.lineTo(cmx+Math.cos(dir+.68)*this.distance, cmy+Math.sin(dir+.68)*this.distance);
			//ctx.stroke();
			ctx.font = "30px Arial";
			//ctx.fillText(parseInt(this.distance), cmx, cmy);


			this.startx1 = cmx+Math.cos(dir+-0.5333)*this.distance;
			this.startx2 = cmx+Math.cos(dir+0.5533)*this.distance
			this.starty1 = cmy+Math.sin(dir+-0.5333)*this.distance;
			this.starty2 = cmy+Math.sin(dir+0.5533)*this.distance;
			this.myangle = getAnglePoints(this.x, this.y, cmx, cmy);;
			this.block1angle = getAnglePoints(this.startx1, this.starty1, cmx, cmy);
			this.block2angle = getAnglePoints(this.startx2, this.starty2, cmx, cmy);
			//ctx.fillText(this.block1angle,  this.startx1, this.starty1);
			//ctx.fillText(this.block1angle,this.startx2, this.starty2);
			this.roundcircum = getAngleDifference(this.block1angle,this.block2angle)/57.2957795*this.distance;
			this.roundcircumtothis = getAngleDifference(this.block1angle,this.myangle)/57.2957795*this.distance;
			this.anglepercent = (this.roundcircumtothis/this.roundcircum);
			//console.log(this.distance)
			ctx.fillStyle = this.color;
			if((length-this.distance)/2>0){
				rect(this.anglepercent*width, height/2+this.z-cmz, (length-this.distance)/2, (length-this.distance)/2);
			}
			//console.log([this.anglepercent*width, height/2, 10, 10, this.anglepercent])
			//rect(this.startx1, this.starty1, 10 , 10);
			//rect(this.startx2, this.starty2, 10, 10);
			
		
	
		}
		else{
			ctx.fillStyle = "red";
		}
		ctx.fillStyle = this.color;
		rect(width/2+(this.x/300), height/2+(this.y/300), 2, 2);
	}
}
function getAngleDifference(x, y){
    return Math.min(Math.abs(x-y), 360-Math.abs(x-y));
}
function getAnglePoints(x1 , y1, x2, y2){
  anglething = Math.atan2(y2 - y1, x2 - x1) * 180 / Math.PI+90;
	anglething = (anglething<0)?anglething+360:anglething;
	return anglething
}
function rect(x, y, w, h){
	ctx.fillRect(x-w/2, y-h/2,  w, h);
}
function area(x1, y1, x2, y2, x3, y3){
	return Math.abs((x1*(y2-y3) + x2*(y3-y1)+ x3*(y1-y2))/2.0);
}
function isInside(x1, y1, x2, y2, x3, y3, x, y)
{let A = area (x1, y1, x2, y2, x3, y3);
let A1 = area (x, y, x2, y2, x3, y3);
let A2 = area (x1, y1, x, y, x3, y3);
let A3 = area (x1, y1, x2, y2, x, y);   
return Math.abs((A1 + A2 + A3)-A)<2;}
function getDistance(x1, y1, x2, y2){
    let y = x2 - x1;
    let x = y2 - y1;
    
    return Math.sqrt(x * x + y * y);
}
function updateall(){
	ctx.clearRect(0, 0, width, height);
	ctx.fillStyle="blue";
	//rect(
	//	camx+Math.cos(camdir)*5,
	//	camy+Math.sin(camdir)*5, 
	//10, 10);
	//ctx.beginPath();
	//ctx.moveTo(camx, camy);
	//ctx.lineTo(camx+Math.cos(camdir-120)*length, camy+Math.sin(camdir-120)*length);
	//ctx.stroke();
	//ctx.beginPath();
	//ctx.moveTo(camx, camy);
	//ctx.lineTo(camx+Math.cos(camdir+120)*length, camy+Math.sin(camdir+120)*length);
	//ctx.stroke();

	//ctx.beginPath();
	//ctx.moveTo(camx+Math.cos(camdir+120)*length, camy+Math.sin(camdir+120)*length);
	//ctx.lineTo(camx+Math.cos(camdir-120)*length, camy+Math.sin(camdir-120)*length);
	//ctx.stroke();
	for(i in objects){
		objects[objects.length-i-1].update(camdir, camx, camy, camz);
	}
	objects.sort((b, a) => parseFloat(b.distance) - parseFloat(a.distance));
	ctx.beginPath()
	ctx.moveTo(width/2+(camx/300), height/2+(camy/300))
	ctx.lineTo(width/2+Math.cos(camdir)*5+(camx/300), height/2+Math.sin(camdir)*5+(camy/300))
	ctx.stroke();
	`console.log({
		x1:parseInt(camx),
		y1:parseInt(camy),
		x2:parseInt(camx+Math.cos(camdir-120)*length),
		y2:parseInt(camy+Math.sin(camdir-120)*length),
		x3:parseInt(camx+Math.cos(camdir+120)*length),
		y3:parseInt(camy+Math.sin(camdir+120)*length)
	})`
}
speed = 3
document.onkeypress = function (eventKeyName) {
	eventKeyName = eventKeyName || window.event;
	if(String.fromCharCode(eventKeyName.keyCode)=="a"){
		camx+=Math.cos(camdir-1.57)*speed;
		camy+=Math.sin(camdir-1.57)*speed;
	}
	if(String.fromCharCode(eventKeyName.keyCode)=="d"){
		camx+=Math.cos(camdir+1.57)*speed;
		camy+=Math.sin(camdir+1.57)*speed;
	}
	if(String.fromCharCode(eventKeyName.keyCode)=="w"){
		camx+=Math.cos(camdir)*speed;
		camy+=Math.sin(camdir)*speed;
	}
	if(String.fromCharCode(eventKeyName.keyCode)=="s"){
		camx-=Math.cos(camdir)*speed;
		camy-=Math.sin(camdir)*speed
	}
	if(String.fromCharCode(eventKeyName.keyCode)=="q"){
		camz-=speed;
	}
	if(String.fromCharCode(eventKeyName.keyCode)=="e"){
		camz+=speed;
	}
	camdir = camdir%(2*Math.PI);
	var camdir360 = Math.abs(camdir * 57.2957795)
	//console.log(camdir360)
	updateall();

}
function createblock(){
	color = '#';
	for (i = 0; i < 6; i++) {
	  color += "0123456789ABCDEF"[Math.floor(Math.random() * 16)];
	}
	objects.push(
		new Player(camx+Math.cos(camdir)*5, camy+Math.sin(camdir)*5, camz, color)
	);
}
updateall();
setInterval(function(){
	updateall();
}, 100)

</script>