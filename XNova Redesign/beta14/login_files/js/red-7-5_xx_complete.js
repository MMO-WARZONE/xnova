
(function(){var
window=this,undefined,_jQuery=window.jQuery,_$=window.$,jQuery=window.jQuery=window.$=function(selector,context){return new jQuery.fn.init(selector,context);},quickExpr=/^[^<]*(<(.|\s)+>)[^>]*$|^#([\w-]+)$/,isSimple=/^.[^:#\[\.,]*$/;jQuery.fn=jQuery.prototype={init:function(selector,context){selector=selector||document;if(selector.nodeType){this[0]=selector;this.length=1;this.context=selector;return this;}
if(typeof selector==="string"){var match=quickExpr.exec(selector);if(match&&(match[1]||!context)){if(match[1])
selector=jQuery.clean([match[1]],context);else{var elem=document.getElementById(match[3]);if(elem&&elem.id!=match[3])
return jQuery().find(selector);var ret=jQuery(elem||[]);ret.context=document;ret.selector=selector;return ret;}}else
return jQuery(context).find(selector);}else if(jQuery.isFunction(selector))
return jQuery(document).ready(selector);if(selector.selector&&selector.context){this.selector=selector.selector;this.context=selector.context;}
return this.setArray(jQuery.makeArray(selector));},selector:"",jquery:"1.3.1",size:function(){return this.length;},get:function(num){return num===undefined?jQuery.makeArray(this):this[num];},pushStack:function(elems,name,selector){var ret=jQuery(elems);ret.prevObject=this;ret.context=this.context;if(name==="find")
ret.selector=this.selector+(this.selector?" ":"")+selector;else if(name)
ret.selector=this.selector+"."+name+"("+selector+")";return ret;},setArray:function(elems){this.length=0;Array.prototype.push.apply(this,elems);return this;},each:function(callback,args){return jQuery.each(this,callback,args);},index:function(elem){return jQuery.inArray(elem&&elem.jquery?elem[0]:elem,this);},attr:function(name,value,type){var options=name;if(typeof name==="string")
if(value===undefined)
return this[0]&&jQuery[type||"attr"](this[0],name);else{options={};options[name]=value;}
return this.each(function(i){for(name in options)
jQuery.attr(type?this.style:this,name,jQuery.prop(this,options[name],type,i,name));});},css:function(key,value){if((key=='width'||key=='height')&&parseFloat(value)<0)
value=undefined;return this.attr(key,value,"curCSS");},text:function(text){if(typeof text!=="object"&&text!=null)
return this.empty().append((this[0]&&this[0].ownerDocument||document).createTextNode(text));var ret="";jQuery.each(text||this,function(){jQuery.each(this.childNodes,function(){if(this.nodeType!=8)
ret+=this.nodeType!=1?this.nodeValue:jQuery.fn.text([this]);});});return ret;},wrapAll:function(html){if(this[0]){var wrap=jQuery(html,this[0].ownerDocument).clone();if(this[0].parentNode)
wrap.insertBefore(this[0]);wrap.map(function(){var elem=this;while(elem.firstChild)
elem=elem.firstChild;return elem;}).append(this);}
return this;},wrapInner:function(html){return this.each(function(){jQuery(this).contents().wrapAll(html);});},wrap:function(html){return this.each(function(){jQuery(this).wrapAll(html);});},append:function(){return this.domManip(arguments,true,function(elem){if(this.nodeType==1)
this.appendChild(elem);});},prepend:function(){return this.domManip(arguments,true,function(elem){if(this.nodeType==1)
this.insertBefore(elem,this.firstChild);});},before:function(){return this.domManip(arguments,false,function(elem){this.parentNode.insertBefore(elem,this);});},after:function(){return this.domManip(arguments,false,function(elem){this.parentNode.insertBefore(elem,this.nextSibling);});},end:function(){return this.prevObject||jQuery([]);},push:[].push,find:function(selector){if(this.length===1&&!/,/.test(selector)){var ret=this.pushStack([],"find",selector);ret.length=0;jQuery.find(selector,this[0],ret);return ret;}else{var elems=jQuery.map(this,function(elem){return jQuery.find(selector,elem);});return this.pushStack(/[^+>] [^+>]/.test(selector)?jQuery.unique(elems):elems,"find",selector);}},clone:function(events){var ret=this.map(function(){if(!jQuery.support.noCloneEvent&&!jQuery.isXMLDoc(this)){var clone=this.cloneNode(true),container=document.createElement("div");container.appendChild(clone);return jQuery.clean([container.innerHTML])[0];}else
return this.cloneNode(true);});var clone=ret.find("*").andSelf().each(function(){if(this[expando]!==undefined)
this[expando]=null;});if(events===true)
this.find("*").andSelf().each(function(i){if(this.nodeType==3)
return;var events=jQuery.data(this,"events");for(var type in events)
for(var handler in events[type])
jQuery.event.add(clone[i],type,events[type][handler],events[type][handler].data);});return ret;},filter:function(selector){return this.pushStack(jQuery.isFunction(selector)&&jQuery.grep(this,function(elem,i){return selector.call(elem,i);})||jQuery.multiFilter(selector,jQuery.grep(this,function(elem){return elem.nodeType===1;})),"filter",selector);},closest:function(selector){var pos=jQuery.expr.match.POS.test(selector)?jQuery(selector):null;return this.map(function(){var cur=this;while(cur&&cur.ownerDocument){if(pos?pos.index(cur)>-1:jQuery(cur).is(selector))
return cur;cur=cur.parentNode;}});},not:function(selector){if(typeof selector==="string")
if(isSimple.test(selector))
return this.pushStack(jQuery.multiFilter(selector,this,true),"not",selector);else
selector=jQuery.multiFilter(selector,this);var isArrayLike=selector.length&&selector[selector.length-1]!==undefined&&!selector.nodeType;return this.filter(function(){return isArrayLike?jQuery.inArray(this,selector)<0:this!=selector;});},add:function(selector){return this.pushStack(jQuery.unique(jQuery.merge(this.get(),typeof selector==="string"?jQuery(selector):jQuery.makeArray(selector))));},is:function(selector){return!!selector&&jQuery.multiFilter(selector,this).length>0;},hasClass:function(selector){return!!selector&&this.is("."+selector);},val:function(value){if(value===undefined){var elem=this[0];if(elem){if(jQuery.nodeName(elem,'option'))
return(elem.attributes.value||{}).specified?elem.value:elem.text;if(jQuery.nodeName(elem,"select")){var index=elem.selectedIndex,values=[],options=elem.options,one=elem.type=="select-one";if(index<0)
return null;for(var i=one?index:0,max=one?index+1:options.length;i<max;i++){var option=options[i];if(option.selected){value=jQuery(option).val();if(one)
return value;values.push(value);}}
return values;}
return(elem.value||"").replace(/\r/g,"");}
return undefined;}
if(typeof value==="number")
value+='';return this.each(function(){if(this.nodeType!=1)
return;if(jQuery.isArray(value)&&/radio|checkbox/.test(this.type))
this.checked=(jQuery.inArray(this.value,value)>=0||jQuery.inArray(this.name,value)>=0);else if(jQuery.nodeName(this,"select")){var values=jQuery.makeArray(value);jQuery("option",this).each(function(){this.selected=(jQuery.inArray(this.value,values)>=0||jQuery.inArray(this.text,values)>=0);});if(!values.length)
this.selectedIndex=-1;}else
this.value=value;});},html:function(value){return value===undefined?(this[0]?this[0].innerHTML:null):this.empty().append(value);},replaceWith:function(value){return this.after(value).remove();},eq:function(i){return this.slice(i,+i+1);},slice:function(){return this.pushStack(Array.prototype.slice.apply(this,arguments),"slice",Array.prototype.slice.call(arguments).join(","));},map:function(callback){return this.pushStack(jQuery.map(this,function(elem,i){return callback.call(elem,i,elem);}));},andSelf:function(){return this.add(this.prevObject);},domManip:function(args,table,callback){if(this[0]){var fragment=(this[0].ownerDocument||this[0]).createDocumentFragment(),scripts=jQuery.clean(args,(this[0].ownerDocument||this[0]),fragment),first=fragment.firstChild,extra=this.length>1?fragment.cloneNode(true):fragment;if(first)
for(var i=0,l=this.length;i<l;i++)
callback.call(root(this[i],first),i>0?extra.cloneNode(true):fragment);if(scripts)
jQuery.each(scripts,evalScript);}
return this;function root(elem,cur){return table&&jQuery.nodeName(elem,"table")&&jQuery.nodeName(cur,"tr")?(elem.getElementsByTagName("tbody")[0]||elem.appendChild(elem.ownerDocument.createElement("tbody"))):elem;}}};jQuery.fn.init.prototype=jQuery.fn;function evalScript(i,elem){if(elem.src)
jQuery.ajax({url:elem.src,async:false,dataType:"script"});else
jQuery.globalEval(elem.text||elem.textContent||elem.innerHTML||"");if(elem.parentNode)
elem.parentNode.removeChild(elem);}
function now(){return+new Date;}
jQuery.extend=jQuery.fn.extend=function(){var target=arguments[0]||{},i=1,length=arguments.length,deep=false,options;if(typeof target==="boolean"){deep=target;target=arguments[1]||{};i=2;}
if(typeof target!=="object"&&!jQuery.isFunction(target))
target={};if(length==i){target=this;--i;}
for(;i<length;i++)
if((options=arguments[i])!=null)
for(var name in options){var src=target[name],copy=options[name];if(target===copy)
continue;if(deep&&copy&&typeof copy==="object"&&!copy.nodeType)
target[name]=jQuery.extend(deep,src||(copy.length!=null?[]:{}),copy);else if(copy!==undefined)
target[name]=copy;}
return target;};var exclude=/z-?index|font-?weight|opacity|zoom|line-?height/i,defaultView=document.defaultView||{},toString=Object.prototype.toString;jQuery.extend({noConflict:function(deep){window.$=_$;if(deep)
window.jQuery=_jQuery;return jQuery;},isFunction:function(obj){return toString.call(obj)==="[object Function]";},isArray:function(obj){return toString.call(obj)==="[object Array]";},isXMLDoc:function(elem){return elem.nodeType===9&&elem.documentElement.nodeName!=="HTML"||!!elem.ownerDocument&&jQuery.isXMLDoc(elem.ownerDocument);},globalEval:function(data){data=jQuery.trim(data);if(data){var head=document.getElementsByTagName("head")[0]||document.documentElement,script=document.createElement("script");script.type="text/javascript";if(jQuery.support.scriptEval)
script.appendChild(document.createTextNode(data));else
script.text=data;head.insertBefore(script,head.firstChild);head.removeChild(script);}},nodeName:function(elem,name){return elem.nodeName&&elem.nodeName.toUpperCase()==name.toUpperCase();},each:function(object,callback,args){var name,i=0,length=object.length;if(args){if(length===undefined){for(name in object)
if(callback.apply(object[name],args)===false)
break;}else
for(;i<length;)
if(callback.apply(object[i++],args)===false)
break;}else{if(length===undefined){for(name in object)
if(callback.call(object[name],name,object[name])===false)
break;}else
for(var value=object[0];i<length&&callback.call(value,i,value)!==false;value=object[++i]){}}
return object;},prop:function(elem,value,type,i,name){if(jQuery.isFunction(value))
value=value.call(elem,i);return typeof value==="number"&&type=="curCSS"&&!exclude.test(name)?value+"px":value;},className:{add:function(elem,classNames){jQuery.each((classNames||"").split(/\s+/),function(i,className){if(elem.nodeType==1&&!jQuery.className.has(elem.className,className))
elem.className+=(elem.className?" ":"")+className;});},remove:function(elem,classNames){if(elem.nodeType==1)
elem.className=classNames!==undefined?jQuery.grep(elem.className.split(/\s+/),function(className){return!jQuery.className.has(classNames,className);}).join(" "):"";},has:function(elem,className){return elem&&jQuery.inArray(className,(elem.className||elem).toString().split(/\s+/))>-1;}},swap:function(elem,options,callback){var old={};for(var name in options){old[name]=elem.style[name];elem.style[name]=options[name];}
callback.call(elem);for(var name in options)
elem.style[name]=old[name];},css:function(elem,name,force){if(name=="width"||name=="height"){var val,props={position:"absolute",visibility:"hidden",display:"block"},which=name=="width"?["Left","Right"]:["Top","Bottom"];function getWH(){val=name=="width"?elem.offsetWidth:elem.offsetHeight;var padding=0,border=0;jQuery.each(which,function(){padding+=parseFloat(jQuery.curCSS(elem,"padding"+this,true))||0;border+=parseFloat(jQuery.curCSS(elem,"border"+this+"Width",true))||0;});val-=Math.round(padding+border);}
if(jQuery(elem).is(":visible"))
getWH();else
jQuery.swap(elem,props,getWH);return Math.max(0,val);}
return jQuery.curCSS(elem,name,force);},curCSS:function(elem,name,force){var ret,style=elem.style;if(name=="opacity"&&!jQuery.support.opacity){ret=jQuery.attr(style,"opacity");return ret==""?"1":ret;}
if(name.match(/float/i))
name=styleFloat;if(!force&&style&&style[name])
ret=style[name];else if(defaultView.getComputedStyle){if(name.match(/float/i))
name="float";name=name.replace(/([A-Z])/g,"-$1").toLowerCase();var computedStyle=defaultView.getComputedStyle(elem,null);if(computedStyle)
ret=computedStyle.getPropertyValue(name);if(name=="opacity"&&ret=="")
ret="1";}else if(elem.currentStyle){var camelCase=name.replace(/\-(\w)/g,function(all,letter){return letter.toUpperCase();});ret=elem.currentStyle[name]||elem.currentStyle[camelCase];if(!/^\d+(px)?$/i.test(ret)&&/^\d/.test(ret)){var left=style.left,rsLeft=elem.runtimeStyle.left;elem.runtimeStyle.left=elem.currentStyle.left;style.left=ret||0;ret=style.pixelLeft+"px";style.left=left;elem.runtimeStyle.left=rsLeft;}}
return ret;},clean:function(elems,context,fragment){context=context||document;if(typeof context.createElement==="undefined")
context=context.ownerDocument||context[0]&&context[0].ownerDocument||document;if(!fragment&&elems.length===1&&typeof elems[0]==="string"){var match=/^<(\w+)\s*\/?>$/.exec(elems[0]);if(match)
return[context.createElement(match[1])];}
var ret=[],scripts=[],div=context.createElement("div");jQuery.each(elems,function(i,elem){if(typeof elem==="number")
elem+='';if(!elem)
return;if(typeof elem==="string"){elem=elem.replace(/(<(\w+)[^>]*?)\/>/g,function(all,front,tag){return tag.match(/^(abbr|br|col|img|input|link|meta|param|hr|area|embed)$/i)?all:front+"></"+tag+">";});var tags=jQuery.trim(elem).toLowerCase();var wrap=!tags.indexOf("<opt")&&[1,"<select multiple='multiple'>","</select>"]||!tags.indexOf("<leg")&&[1,"<fieldset>","</fieldset>"]||tags.match(/^<(thead|tbody|tfoot|colg|cap)/)&&[1,"<table>","</table>"]||!tags.indexOf("<tr")&&[2,"<table><tbody>","</tbody></table>"]||(!tags.indexOf("<td")||!tags.indexOf("<th"))&&[3,"<table><tbody><tr>","</tr></tbody></table>"]||!tags.indexOf("<col")&&[2,"<table><tbody></tbody><colgroup>","</colgroup></table>"]||!jQuery.support.htmlSerialize&&[1,"div<div>","</div>"]||[0,"",""];div.innerHTML=wrap[1]+elem+wrap[2];while(wrap[0]--)
div=div.lastChild;if(!jQuery.support.tbody){var tbody=!tags.indexOf("<table")&&tags.indexOf("<tbody")<0?div.firstChild&&div.firstChild.childNodes:wrap[1]=="<table>"&&tags.indexOf("<tbody")<0?div.childNodes:[];for(var j=tbody.length-1;j>=0;--j)
if(jQuery.nodeName(tbody[j],"tbody")&&!tbody[j].childNodes.length)
tbody[j].parentNode.removeChild(tbody[j]);}
if(!jQuery.support.leadingWhitespace&&/^\s/.test(elem))
div.insertBefore(context.createTextNode(elem.match(/^\s*/)[0]),div.firstChild);elem=jQuery.makeArray(div.childNodes);}
if(elem.nodeType)
ret.push(elem);else
ret=jQuery.merge(ret,elem);});if(fragment){for(var i=0;ret[i];i++){if(jQuery.nodeName(ret[i],"script")&&(!ret[i].type||ret[i].type.toLowerCase()==="text/javascript")){scripts.push(ret[i].parentNode?ret[i].parentNode.removeChild(ret[i]):ret[i]);}else{if(ret[i].nodeType===1)
ret.splice.apply(ret,[i+1,0].concat(jQuery.makeArray(ret[i].getElementsByTagName("script"))));fragment.appendChild(ret[i]);}}
return scripts;}
return ret;},attr:function(elem,name,value){if(!elem||elem.nodeType==3||elem.nodeType==8)
return undefined;var notxml=!jQuery.isXMLDoc(elem),set=value!==undefined;name=notxml&&jQuery.props[name]||name;if(elem.tagName){var special=/href|src|style/.test(name);if(name=="selected"&&elem.parentNode)
elem.parentNode.selectedIndex;if(name in elem&&notxml&&!special){if(set){if(name=="type"&&jQuery.nodeName(elem,"input")&&elem.parentNode)
throw"type property can't be changed";elem[name]=value;}
if(jQuery.nodeName(elem,"form")&&elem.getAttributeNode(name))
return elem.getAttributeNode(name).nodeValue;if(name=="tabIndex"){var attributeNode=elem.getAttributeNode("tabIndex");return attributeNode&&attributeNode.specified?attributeNode.value:elem.nodeName.match(/(button|input|object|select|textarea)/i)?0:elem.nodeName.match(/^(a|area)$/i)&&elem.href?0:undefined;}
return elem[name];}
if(!jQuery.support.style&&notxml&&name=="style")
return jQuery.attr(elem.style,"cssText",value);if(set)
elem.setAttribute(name,""+value);var attr=!jQuery.support.hrefNormalized&&notxml&&special?elem.getAttribute(name,2):elem.getAttribute(name);return attr===null?undefined:attr;}
if(!jQuery.support.opacity&&name=="opacity"){if(set){elem.zoom=1;elem.filter=(elem.filter||"").replace(/alpha\([^)]*\)/,"")+
(parseInt(value)+''=="NaN"?"":"alpha(opacity="+value*100+")");}
return elem.filter&&elem.filter.indexOf("opacity=")>=0?(parseFloat(elem.filter.match(/opacity=([^)]*)/)[1])/100)+'':"";}
name=name.replace(/-([a-z])/ig,function(all,letter){return letter.toUpperCase();});if(set)
elem[name]=value;return elem[name];},trim:function(text){return(text||"").replace(/^\s+|\s+$/g,"");},makeArray:function(array){var ret=[];if(array!=null){var i=array.length;if(i==null||typeof array==="string"||jQuery.isFunction(array)||array.setInterval)
ret[0]=array;else
while(i)
ret[--i]=array[i];}
return ret;},inArray:function(elem,array){for(var i=0,length=array.length;i<length;i++)
if(array[i]===elem)
return i;return-1;},merge:function(first,second){var i=0,elem,pos=first.length;if(!jQuery.support.getAll){while((elem=second[i++])!=null)
if(elem.nodeType!=8)
first[pos++]=elem;}else
while((elem=second[i++])!=null)
first[pos++]=elem;return first;},unique:function(array){var ret=[],done={};try{for(var i=0,length=array.length;i<length;i++){var id=jQuery.data(array[i]);if(!done[id]){done[id]=true;ret.push(array[i]);}}}catch(e){ret=array;}
return ret;},grep:function(elems,callback,inv){var ret=[];for(var i=0,length=elems.length;i<length;i++)
if(!inv!=!callback(elems[i],i))
ret.push(elems[i]);return ret;},map:function(elems,callback){var ret=[];for(var i=0,length=elems.length;i<length;i++){var value=callback(elems[i],i);if(value!=null)
ret[ret.length]=value;}
return ret.concat.apply([],ret);}});var userAgent=navigator.userAgent.toLowerCase();jQuery.browser={version:(userAgent.match(/.+(?:rv|it|ra|ie)[\/: ]([\d.]+)/)||[0,'0'])[1],safari:/webkit/.test(userAgent),opera:/opera/.test(userAgent),msie:/msie/.test(userAgent)&&!/opera/.test(userAgent),mozilla:/mozilla/.test(userAgent)&&!/(compatible|webkit)/.test(userAgent)};jQuery.each({parent:function(elem){return elem.parentNode;},parents:function(elem){return jQuery.dir(elem,"parentNode");},next:function(elem){return jQuery.nth(elem,2,"nextSibling");},prev:function(elem){return jQuery.nth(elem,2,"previousSibling");},nextAll:function(elem){return jQuery.dir(elem,"nextSibling");},prevAll:function(elem){return jQuery.dir(elem,"previousSibling");},siblings:function(elem){return jQuery.sibling(elem.parentNode.firstChild,elem);},children:function(elem){return jQuery.sibling(elem.firstChild);},contents:function(elem){return jQuery.nodeName(elem,"iframe")?elem.contentDocument||elem.contentWindow.document:jQuery.makeArray(elem.childNodes);}},function(name,fn){jQuery.fn[name]=function(selector){var ret=jQuery.map(this,fn);if(selector&&typeof selector=="string")
ret=jQuery.multiFilter(selector,ret);return this.pushStack(jQuery.unique(ret),name,selector);};});jQuery.each({appendTo:"append",prependTo:"prepend",insertBefore:"before",insertAfter:"after",replaceAll:"replaceWith"},function(name,original){jQuery.fn[name]=function(){var args=arguments;return this.each(function(){for(var i=0,length=args.length;i<length;i++)
jQuery(args[i])[original](this);});};});jQuery.each({removeAttr:function(name){jQuery.attr(this,name,"");if(this.nodeType==1)
this.removeAttribute(name);},addClass:function(classNames){jQuery.className.add(this,classNames);},removeClass:function(classNames){jQuery.className.remove(this,classNames);},toggleClass:function(classNames,state){if(typeof state!=="boolean")
state=!jQuery.className.has(this,classNames);jQuery.className[state?"add":"remove"](this,classNames);},remove:function(selector){if(!selector||jQuery.filter(selector,[this]).length){jQuery("*",this).add([this]).each(function(){jQuery.event.remove(this);jQuery.removeData(this);});if(this.parentNode)
this.parentNode.removeChild(this);}},empty:function(){jQuery(">*",this).remove();while(this.firstChild)
this.removeChild(this.firstChild);}},function(name,fn){jQuery.fn[name]=function(){return this.each(fn,arguments);};});function num(elem,prop){return elem[0]&&parseInt(jQuery.curCSS(elem[0],prop,true),10)||0;}
var expando="jQuery"+now(),uuid=0,windowData={};jQuery.extend({cache:{},data:function(elem,name,data){elem=elem==window?windowData:elem;var id=elem[expando];if(!id)
id=elem[expando]=++uuid;if(name&&!jQuery.cache[id])
jQuery.cache[id]={};if(data!==undefined)
jQuery.cache[id][name]=data;return name?jQuery.cache[id][name]:id;},removeData:function(elem,name){elem=elem==window?windowData:elem;var id=elem[expando];if(name){if(jQuery.cache[id]){delete jQuery.cache[id][name];name="";for(name in jQuery.cache[id])
break;if(!name)
jQuery.removeData(elem);}}else{try{delete elem[expando];}catch(e){if(elem.removeAttribute)
elem.removeAttribute(expando);}
delete jQuery.cache[id];}},queue:function(elem,type,data){if(elem){type=(type||"fx")+"queue";var q=jQuery.data(elem,type);if(!q||jQuery.isArray(data))
q=jQuery.data(elem,type,jQuery.makeArray(data));else if(data)
q.push(data);}
return q;},dequeue:function(elem,type){var queue=jQuery.queue(elem,type),fn=queue.shift();if(!type||type==="fx")
fn=queue[0];if(fn!==undefined)
fn.call(elem);}});jQuery.fn.extend({data:function(key,value){var parts=key.split(".");parts[1]=parts[1]?"."+parts[1]:"";if(value===undefined){var data=this.triggerHandler("getData"+parts[1]+"!",[parts[0]]);if(data===undefined&&this.length)
data=jQuery.data(this[0],key);return data===undefined&&parts[1]?this.data(parts[0]):data;}else
return this.trigger("setData"+parts[1]+"!",[parts[0],value]).each(function(){jQuery.data(this,key,value);});},removeData:function(key){return this.each(function(){jQuery.removeData(this,key);});},queue:function(type,data){if(typeof type!=="string"){data=type;type="fx";}
if(data===undefined)
return jQuery.queue(this[0],type);return this.each(function(){var queue=jQuery.queue(this,type,data);if(type=="fx"&&queue.length==1)
queue[0].call(this);});},dequeue:function(type){return this.each(function(){jQuery.dequeue(this,type);});}});(function(){var chunker=/((?:\((?:\([^()]+\)|[^()]+)+\)|\[(?:\[[^[\]]*\]|['"][^'"]+['"]|[^[\]'"]+)+\]|\\.|[^ >+~,(\[]+)+|[>+~])(\s*,\s*)?/g,done=0,toString=Object.prototype.toString;var Sizzle=function(selector,context,results,seed){results=results||[];context=context||document;if(context.nodeType!==1&&context.nodeType!==9)
return[];if(!selector||typeof selector!=="string"){return results;}
var parts=[],m,set,checkSet,check,mode,extra,prune=true;chunker.lastIndex=0;while((m=chunker.exec(selector))!==null){parts.push(m[1]);if(m[2]){extra=RegExp.rightContext;break;}}
if(parts.length>1&&origPOS.exec(selector)){if(parts.length===2&&Expr.relative[parts[0]]){set=posProcess(parts[0]+parts[1],context);}else{set=Expr.relative[parts[0]]?[context]:Sizzle(parts.shift(),context);while(parts.length){selector=parts.shift();if(Expr.relative[selector])
selector+=parts.shift();set=posProcess(selector,set);}}}else{var ret=seed?{expr:parts.pop(),set:makeArray(seed)}:Sizzle.find(parts.pop(),parts.length===1&&context.parentNode?context.parentNode:context,isXML(context));set=Sizzle.filter(ret.expr,ret.set);if(parts.length>0){checkSet=makeArray(set);}else{prune=false;}
while(parts.length){var cur=parts.pop(),pop=cur;if(!Expr.relative[cur]){cur="";}else{pop=parts.pop();}
if(pop==null){pop=context;}
Expr.relative[cur](checkSet,pop,isXML(context));}}
if(!checkSet){checkSet=set;}
if(!checkSet){throw"Syntax error, unrecognized expression: "+(cur||selector);}
if(toString.call(checkSet)==="[object Array]"){if(!prune){results.push.apply(results,checkSet);}else if(context.nodeType===1){for(var i=0;checkSet[i]!=null;i++){if(checkSet[i]&&(checkSet[i]===true||checkSet[i].nodeType===1&&contains(context,checkSet[i]))){results.push(set[i]);}}}else{for(var i=0;checkSet[i]!=null;i++){if(checkSet[i]&&checkSet[i].nodeType===1){results.push(set[i]);}}}}else{makeArray(checkSet,results);}
if(extra){Sizzle(extra,context,results,seed);}
return results;};Sizzle.matches=function(expr,set){return Sizzle(expr,null,null,set);};Sizzle.find=function(expr,context,isXML){var set,match;if(!expr){return[];}
for(var i=0,l=Expr.order.length;i<l;i++){var type=Expr.order[i],match;if((match=Expr.match[type].exec(expr))){var left=RegExp.leftContext;if(left.substr(left.length-1)!=="\\"){match[1]=(match[1]||"").replace(/\\/g,"");set=Expr.find[type](match,context,isXML);if(set!=null){expr=expr.replace(Expr.match[type],"");break;}}}}
if(!set){set=context.getElementsByTagName("*");}
return{set:set,expr:expr};};Sizzle.filter=function(expr,set,inplace,not){var old=expr,result=[],curLoop=set,match,anyFound;while(expr&&set.length){for(var type in Expr.filter){if((match=Expr.match[type].exec(expr))!=null){var filter=Expr.filter[type],found,item;anyFound=false;if(curLoop==result){result=[];}
if(Expr.preFilter[type]){match=Expr.preFilter[type](match,curLoop,inplace,result,not);if(!match){anyFound=found=true;}else if(match===true){continue;}}
if(match){for(var i=0;(item=curLoop[i])!=null;i++){if(item){found=filter(item,match,i,curLoop);var pass=not^!!found;if(inplace&&found!=null){if(pass){anyFound=true;}else{curLoop[i]=false;}}else if(pass){result.push(item);anyFound=true;}}}}
if(found!==undefined){if(!inplace){curLoop=result;}
expr=expr.replace(Expr.match[type],"");if(!anyFound){return[];}
break;}}}
expr=expr.replace(/\s*,\s*/,"");if(expr==old){if(anyFound==null){throw"Syntax error, unrecognized expression: "+expr;}else{break;}}
old=expr;}
return curLoop;};var Expr=Sizzle.selectors={order:["ID","NAME","TAG"],match:{ID:/#((?:[\w\u00c0-\uFFFF_-]|\\.)+)/,CLASS:/\.((?:[\w\u00c0-\uFFFF_-]|\\.)+)/,NAME:/\[name=['"]*((?:[\w\u00c0-\uFFFF_-]|\\.)+)['"]*\]/,ATTR:/\[\s*((?:[\w\u00c0-\uFFFF_-]|\\.)+)\s*(?:(\S?=)\s*(['"]*)(.*?)\3|)\s*\]/,TAG:/^((?:[\w\u00c0-\uFFFF\*_-]|\\.)+)/,CHILD:/:(only|nth|last|first)-child(?:\((even|odd|[\dn+-]*)\))?/,POS:/:(nth|eq|gt|lt|first|last|even|odd)(?:\((\d*)\))?(?=[^-]|$)/,PSEUDO:/:((?:[\w\u00c0-\uFFFF_-]|\\.)+)(?:\((['"]*)((?:\([^\)]+\)|[^\2\(\)]*)+)\2\))?/},attrMap:{"class":"className","for":"htmlFor"},attrHandle:{href:function(elem){return elem.getAttribute("href");}},relative:{"+":function(checkSet,part){for(var i=0,l=checkSet.length;i<l;i++){var elem=checkSet[i];if(elem){var cur=elem.previousSibling;while(cur&&cur.nodeType!==1){cur=cur.previousSibling;}
checkSet[i]=typeof part==="string"?cur||false:cur===part;}}
if(typeof part==="string"){Sizzle.filter(part,checkSet,true);}},">":function(checkSet,part,isXML){if(typeof part==="string"&&!/\W/.test(part)){part=isXML?part:part.toUpperCase();for(var i=0,l=checkSet.length;i<l;i++){var elem=checkSet[i];if(elem){var parent=elem.parentNode;checkSet[i]=parent.nodeName===part?parent:false;}}}else{for(var i=0,l=checkSet.length;i<l;i++){var elem=checkSet[i];if(elem){checkSet[i]=typeof part==="string"?elem.parentNode:elem.parentNode===part;}}
if(typeof part==="string"){Sizzle.filter(part,checkSet,true);}}},"":function(checkSet,part,isXML){var doneName="done"+(done++),checkFn=dirCheck;if(!part.match(/\W/)){var nodeCheck=part=isXML?part:part.toUpperCase();checkFn=dirNodeCheck;}
checkFn("parentNode",part,doneName,checkSet,nodeCheck,isXML);},"~":function(checkSet,part,isXML){var doneName="done"+(done++),checkFn=dirCheck;if(typeof part==="string"&&!part.match(/\W/)){var nodeCheck=part=isXML?part:part.toUpperCase();checkFn=dirNodeCheck;}
checkFn("previousSibling",part,doneName,checkSet,nodeCheck,isXML);}},find:{ID:function(match,context,isXML){if(typeof context.getElementById!=="undefined"&&!isXML){var m=context.getElementById(match[1]);return m?[m]:[];}},NAME:function(match,context,isXML){if(typeof context.getElementsByName!=="undefined"&&!isXML){return context.getElementsByName(match[1]);}},TAG:function(match,context){return context.getElementsByTagName(match[1]);}},preFilter:{CLASS:function(match,curLoop,inplace,result,not){match=" "+match[1].replace(/\\/g,"")+" ";var elem;for(var i=0;(elem=curLoop[i])!=null;i++){if(elem){if(not^(" "+elem.className+" ").indexOf(match)>=0){if(!inplace)
result.push(elem);}else if(inplace){curLoop[i]=false;}}}
return false;},ID:function(match){return match[1].replace(/\\/g,"");},TAG:function(match,curLoop){for(var i=0;curLoop[i]===false;i++){}
return curLoop[i]&&isXML(curLoop[i])?match[1]:match[1].toUpperCase();},CHILD:function(match){if(match[1]=="nth"){var test=/(-?)(\d*)n((?:\+|-)?\d*)/.exec(match[2]=="even"&&"2n"||match[2]=="odd"&&"2n+1"||!/\D/.test(match[2])&&"0n+"+match[2]||match[2]);match[2]=(test[1]+(test[2]||1))-0;match[3]=test[3]-0;}
match[0]="done"+(done++);return match;},ATTR:function(match){var name=match[1].replace(/\\/g,"");if(Expr.attrMap[name]){match[1]=Expr.attrMap[name];}
if(match[2]==="~="){match[4]=" "+match[4]+" ";}
return match;},PSEUDO:function(match,curLoop,inplace,result,not){if(match[1]==="not"){if(match[3].match(chunker).length>1){match[3]=Sizzle(match[3],null,null,curLoop);}else{var ret=Sizzle.filter(match[3],curLoop,inplace,true^not);if(!inplace){result.push.apply(result,ret);}
return false;}}else if(Expr.match.POS.test(match[0])){return true;}
return match;},POS:function(match){match.unshift(true);return match;}},filters:{enabled:function(elem){return elem.disabled===false&&elem.type!=="hidden";},disabled:function(elem){return elem.disabled===true;},checked:function(elem){return elem.checked===true;},selected:function(elem){elem.parentNode.selectedIndex;return elem.selected===true;},parent:function(elem){return!!elem.firstChild;},empty:function(elem){return!elem.firstChild;},has:function(elem,i,match){return!!Sizzle(match[3],elem).length;},header:function(elem){return/h\d/i.test(elem.nodeName);},text:function(elem){return"text"===elem.type;},radio:function(elem){return"radio"===elem.type;},checkbox:function(elem){return"checkbox"===elem.type;},file:function(elem){return"file"===elem.type;},password:function(elem){return"password"===elem.type;},submit:function(elem){return"submit"===elem.type;},image:function(elem){return"image"===elem.type;},reset:function(elem){return"reset"===elem.type;},button:function(elem){return"button"===elem.type||elem.nodeName.toUpperCase()==="BUTTON";},input:function(elem){return/input|select|textarea|button/i.test(elem.nodeName);}},setFilters:{first:function(elem,i){return i===0;},last:function(elem,i,match,array){return i===array.length-1;},even:function(elem,i){return i%2===0;},odd:function(elem,i){return i%2===1;},lt:function(elem,i,match){return i<match[3]-0;},gt:function(elem,i,match){return i>match[3]-0;},nth:function(elem,i,match){return match[3]-0==i;},eq:function(elem,i,match){return match[3]-0==i;}},filter:{CHILD:function(elem,match){var type=match[1],parent=elem.parentNode;var doneName=match[0];if(parent&&(!parent[doneName]||!elem.nodeIndex)){var count=1;for(var node=parent.firstChild;node;node=node.nextSibling){if(node.nodeType==1){node.nodeIndex=count++;}}
parent[doneName]=count-1;}
if(type=="first"){return elem.nodeIndex==1;}else if(type=="last"){return elem.nodeIndex==parent[doneName];}else if(type=="only"){return parent[doneName]==1;}else if(type=="nth"){var add=false,first=match[2],last=match[3];if(first==1&&last==0){return true;}
if(first==0){if(elem.nodeIndex==last){add=true;}}else if((elem.nodeIndex-last)%first==0&&(elem.nodeIndex-last)/first>=0){add=true;}
return add;}},PSEUDO:function(elem,match,i,array){var name=match[1],filter=Expr.filters[name];if(filter){return filter(elem,i,match,array);}else if(name==="contains"){return(elem.textContent||elem.innerText||"").indexOf(match[3])>=0;}else if(name==="not"){var not=match[3];for(var i=0,l=not.length;i<l;i++){if(not[i]===elem){return false;}}
return true;}},ID:function(elem,match){return elem.nodeType===1&&elem.getAttribute("id")===match;},TAG:function(elem,match){return(match==="*"&&elem.nodeType===1)||elem.nodeName===match;},CLASS:function(elem,match){return match.test(elem.className);},ATTR:function(elem,match){var result=Expr.attrHandle[match[1]]?Expr.attrHandle[match[1]](elem):elem[match[1]]||elem.getAttribute(match[1]),value=result+"",type=match[2],check=match[4];return result==null?type==="!=":type==="="?value===check:type==="*="?value.indexOf(check)>=0:type==="~="?(" "+value+" ").indexOf(check)>=0:!match[4]?result:type==="!="?value!=check:type==="^="?value.indexOf(check)===0:type==="$="?value.substr(value.length-check.length)===check:type==="|="?value===check||value.substr(0,check.length+1)===check+"-":false;},POS:function(elem,match,i,array){var name=match[2],filter=Expr.setFilters[name];if(filter){return filter(elem,i,match,array);}}}};var origPOS=Expr.match.POS;for(var type in Expr.match){Expr.match[type]=RegExp(Expr.match[type].source+/(?![^\[]*\])(?![^\(]*\))/.source);}
var makeArray=function(array,results){array=Array.prototype.slice.call(array);if(results){results.push.apply(results,array);return results;}
return array;};try{Array.prototype.slice.call(document.documentElement.childNodes);}catch(e){makeArray=function(array,results){var ret=results||[];if(toString.call(array)==="[object Array]"){Array.prototype.push.apply(ret,array);}else{if(typeof array.length==="number"){for(var i=0,l=array.length;i<l;i++){ret.push(array[i]);}}else{for(var i=0;array[i];i++){ret.push(array[i]);}}}
return ret;};}
(function(){var form=document.createElement("form"),id="script"+(new Date).getTime();form.innerHTML="<input name='"+id+"'/>";var root=document.documentElement;root.insertBefore(form,root.firstChild);if(!!document.getElementById(id)){Expr.find.ID=function(match,context,isXML){if(typeof context.getElementById!=="undefined"&&!isXML){var m=context.getElementById(match[1]);return m?m.id===match[1]||typeof m.getAttributeNode!=="undefined"&&m.getAttributeNode("id").nodeValue===match[1]?[m]:undefined:[];}};Expr.filter.ID=function(elem,match){var node=typeof elem.getAttributeNode!=="undefined"&&elem.getAttributeNode("id");return elem.nodeType===1&&node&&node.nodeValue===match;};}
root.removeChild(form);})();(function(){var div=document.createElement("div");div.appendChild(document.createComment(""));if(div.getElementsByTagName("*").length>0){Expr.find.TAG=function(match,context){var results=context.getElementsByTagName(match[1]);if(match[1]==="*"){var tmp=[];for(var i=0;results[i];i++){if(results[i].nodeType===1){tmp.push(results[i]);}}
results=tmp;}
return results;};}
div.innerHTML="<a href='#'></a>";if(div.firstChild&&div.firstChild.getAttribute("href")!=="#"){Expr.attrHandle.href=function(elem){return elem.getAttribute("href",2);};}})();if(document.querySelectorAll)(function(){var oldSizzle=Sizzle,div=document.createElement("div");div.innerHTML="<p class='TEST'></p>";if(div.querySelectorAll&&div.querySelectorAll(".TEST").length===0){return;}
Sizzle=function(query,context,extra,seed){context=context||document;if(!seed&&context.nodeType===9&&!isXML(context)){try{return makeArray(context.querySelectorAll(query),extra);}catch(e){}}
return oldSizzle(query,context,extra,seed);};Sizzle.find=oldSizzle.find;Sizzle.filter=oldSizzle.filter;Sizzle.selectors=oldSizzle.selectors;Sizzle.matches=oldSizzle.matches;})();if(document.getElementsByClassName&&document.documentElement.getElementsByClassName){Expr.order.splice(1,0,"CLASS");Expr.find.CLASS=function(match,context){return context.getElementsByClassName(match[1]);};}
function dirNodeCheck(dir,cur,doneName,checkSet,nodeCheck,isXML){for(var i=0,l=checkSet.length;i<l;i++){var elem=checkSet[i];if(elem){elem=elem[dir];var match=false;while(elem&&elem.nodeType){var done=elem[doneName];if(done){match=checkSet[done];break;}
if(elem.nodeType===1&&!isXML)
elem[doneName]=i;if(elem.nodeName===cur){match=elem;break;}
elem=elem[dir];}
checkSet[i]=match;}}}
function dirCheck(dir,cur,doneName,checkSet,nodeCheck,isXML){for(var i=0,l=checkSet.length;i<l;i++){var elem=checkSet[i];if(elem){elem=elem[dir];var match=false;while(elem&&elem.nodeType){if(elem[doneName]){match=checkSet[elem[doneName]];break;}
if(elem.nodeType===1){if(!isXML)
elem[doneName]=i;if(typeof cur!=="string"){if(elem===cur){match=true;break;}}else if(Sizzle.filter(cur,[elem]).length>0){match=elem;break;}}
elem=elem[dir];}
checkSet[i]=match;}}}
var contains=document.compareDocumentPosition?function(a,b){return a.compareDocumentPosition(b)&16;}:function(a,b){return a!==b&&(a.contains?a.contains(b):true);};var isXML=function(elem){return elem.nodeType===9&&elem.documentElement.nodeName!=="HTML"||!!elem.ownerDocument&&isXML(elem.ownerDocument);};var posProcess=function(selector,context){var tmpSet=[],later="",match,root=context.nodeType?[context]:context;while((match=Expr.match.PSEUDO.exec(selector))){later+=match[0];selector=selector.replace(Expr.match.PSEUDO,"");}
selector=Expr.relative[selector]?selector+"*":selector;for(var i=0,l=root.length;i<l;i++){Sizzle(selector,root[i],tmpSet);}
return Sizzle.filter(later,tmpSet);};jQuery.find=Sizzle;jQuery.filter=Sizzle.filter;jQuery.expr=Sizzle.selectors;jQuery.expr[":"]=jQuery.expr.filters;Sizzle.selectors.filters.hidden=function(elem){return"hidden"===elem.type||jQuery.css(elem,"display")==="none"||jQuery.css(elem,"visibility")==="hidden";};Sizzle.selectors.filters.visible=function(elem){return"hidden"!==elem.type&&jQuery.css(elem,"display")!=="none"&&jQuery.css(elem,"visibility")!=="hidden";};Sizzle.selectors.filters.animated=function(elem){return jQuery.grep(jQuery.timers,function(fn){return elem===fn.elem;}).length;};jQuery.multiFilter=function(expr,elems,not){if(not){expr=":not("+expr+")";}
return Sizzle.matches(expr,elems);};jQuery.dir=function(elem,dir){var matched=[],cur=elem[dir];while(cur&&cur!=document){if(cur.nodeType==1)
matched.push(cur);cur=cur[dir];}
return matched;};jQuery.nth=function(cur,result,dir,elem){result=result||1;var num=0;for(;cur;cur=cur[dir])
if(cur.nodeType==1&&++num==result)
break;return cur;};jQuery.sibling=function(n,elem){var r=[];for(;n;n=n.nextSibling){if(n.nodeType==1&&n!=elem)
r.push(n);}
return r;};return;window.Sizzle=Sizzle;})();jQuery.event={add:function(elem,types,handler,data){if(elem.nodeType==3||elem.nodeType==8)
return;if(elem.setInterval&&elem!=window)
elem=window;if(!handler.guid)
handler.guid=this.guid++;if(data!==undefined){var fn=handler;handler=this.proxy(fn);handler.data=data;}
var events=jQuery.data(elem,"events")||jQuery.data(elem,"events",{}),handle=jQuery.data(elem,"handle")||jQuery.data(elem,"handle",function(){return typeof jQuery!=="undefined"&&!jQuery.event.triggered?jQuery.event.handle.apply(arguments.callee.elem,arguments):undefined;});handle.elem=elem;jQuery.each(types.split(/\s+/),function(index,type){var namespaces=type.split(".");type=namespaces.shift();handler.type=namespaces.slice().sort().join(".");var handlers=events[type];if(jQuery.event.specialAll[type])
jQuery.event.specialAll[type].setup.call(elem,data,namespaces);if(!handlers){handlers=events[type]={};if(!jQuery.event.special[type]||jQuery.event.special[type].setup.call(elem,data,namespaces)===false){if(elem.addEventListener)
elem.addEventListener(type,handle,false);else if(elem.attachEvent)
elem.attachEvent("on"+type,handle);}}
handlers[handler.guid]=handler;jQuery.event.global[type]=true;});elem=null;},guid:1,global:{},remove:function(elem,types,handler){if(elem.nodeType==3||elem.nodeType==8)
return;var events=jQuery.data(elem,"events"),ret,index;if(events){if(types===undefined||(typeof types==="string"&&types.charAt(0)=="."))
for(var type in events)
this.remove(elem,type+(types||""));else{if(types.type){handler=types.handler;types=types.type;}
jQuery.each(types.split(/\s+/),function(index,type){var namespaces=type.split(".");type=namespaces.shift();var namespace=RegExp("(^|\\.)"+namespaces.slice().sort().join(".*\\.")+"(\\.|$)");if(events[type]){if(handler)
delete events[type][handler.guid];else
for(var handle in events[type])
if(namespace.test(events[type][handle].type))
delete events[type][handle];if(jQuery.event.specialAll[type])
jQuery.event.specialAll[type].teardown.call(elem,namespaces);for(ret in events[type])break;if(!ret){if(!jQuery.event.special[type]||jQuery.event.special[type].teardown.call(elem,namespaces)===false){if(elem.removeEventListener)
elem.removeEventListener(type,jQuery.data(elem,"handle"),false);else if(elem.detachEvent)
elem.detachEvent("on"+type,jQuery.data(elem,"handle"));}
ret=null;delete events[type];}}});}
for(ret in events)break;if(!ret){var handle=jQuery.data(elem,"handle");if(handle)handle.elem=null;jQuery.removeData(elem,"events");jQuery.removeData(elem,"handle");}}},trigger:function(event,data,elem,bubbling){var type=event.type||event;if(!bubbling){event=typeof event==="object"?event[expando]?event:jQuery.extend(jQuery.Event(type),event):jQuery.Event(type);if(type.indexOf("!")>=0){event.type=type=type.slice(0,-1);event.exclusive=true;}
if(!elem){event.stopPropagation();if(this.global[type])
jQuery.each(jQuery.cache,function(){if(this.events&&this.events[type])
jQuery.event.trigger(event,data,this.handle.elem);});}
if(!elem||elem.nodeType==3||elem.nodeType==8)
return undefined;event.result=undefined;event.target=elem;data=jQuery.makeArray(data);data.unshift(event);}
event.currentTarget=elem;var handle=jQuery.data(elem,"handle");if(handle)
handle.apply(elem,data);if((!elem[type]||(jQuery.nodeName(elem,'a')&&type=="click"))&&elem["on"+type]&&elem["on"+type].apply(elem,data)===false)
event.result=false;if(!bubbling&&elem[type]&&!event.isDefaultPrevented()&&!(jQuery.nodeName(elem,'a')&&type=="click")){this.triggered=true;try{elem[type]();}catch(e){}}
this.triggered=false;if(!event.isPropagationStopped()){var parent=elem.parentNode||elem.ownerDocument;if(parent)
jQuery.event.trigger(event,data,parent,true);}},handle:function(event){var all,handlers;event=arguments[0]=jQuery.event.fix(event||window.event);var namespaces=event.type.split(".");event.type=namespaces.shift();all=!namespaces.length&&!event.exclusive;var namespace=RegExp("(^|\\.)"+namespaces.slice().sort().join(".*\\.")+"(\\.|$)");handlers=(jQuery.data(this,"events")||{})[event.type];for(var j in handlers){var handler=handlers[j];if(all||namespace.test(handler.type)){event.handler=handler;event.data=handler.data;var ret=handler.apply(this,arguments);if(ret!==undefined){event.result=ret;if(ret===false){event.preventDefault();event.stopPropagation();}}
if(event.isImmediatePropagationStopped())
break;}}},props:"altKey attrChange attrName bubbles button cancelable charCode clientX clientY ctrlKey currentTarget data detail eventPhase fromElement handler keyCode metaKey newValue originalTarget pageX pageY prevValue relatedNode relatedTarget screenX screenY shiftKey srcElement target toElement view wheelDelta which".split(" "),fix:function(event){if(event[expando])
return event;var originalEvent=event;event=jQuery.Event(originalEvent);for(var i=this.props.length,prop;i;){prop=this.props[--i];event[prop]=originalEvent[prop];}
if(!event.target)
event.target=event.srcElement||document;if(event.target.nodeType==3)
event.target=event.target.parentNode;if(!event.relatedTarget&&event.fromElement)
event.relatedTarget=event.fromElement==event.target?event.toElement:event.fromElement;if(event.pageX==null&&event.clientX!=null){var doc=document.documentElement,body=document.body;event.pageX=event.clientX+(doc&&doc.scrollLeft||body&&body.scrollLeft||0)-(doc.clientLeft||0);event.pageY=event.clientY+(doc&&doc.scrollTop||body&&body.scrollTop||0)-(doc.clientTop||0);}
if(!event.which&&((event.charCode||event.charCode===0)?event.charCode:event.keyCode))
event.which=event.charCode||event.keyCode;if(!event.metaKey&&event.ctrlKey)
event.metaKey=event.ctrlKey;if(!event.which&&event.button)
event.which=(event.button&1?1:(event.button&2?3:(event.button&4?2:0)));return event;},proxy:function(fn,proxy){proxy=proxy||function(){return fn.apply(this,arguments);};proxy.guid=fn.guid=fn.guid||proxy.guid||this.guid++;return proxy;},special:{ready:{setup:bindReady,teardown:function(){}}},specialAll:{live:{setup:function(selector,namespaces){jQuery.event.add(this,namespaces[0],liveHandler);},teardown:function(namespaces){if(namespaces.length){var remove=0,name=RegExp("(^|\\.)"+namespaces[0]+"(\\.|$)");jQuery.each((jQuery.data(this,"events").live||{}),function(){if(name.test(this.type))
remove++;});if(remove<1)
jQuery.event.remove(this,namespaces[0],liveHandler);}}}}};jQuery.Event=function(src){if(!this.preventDefault)
return new jQuery.Event(src);if(src&&src.type){this.originalEvent=src;this.type=src.type;}else
this.type=src;this.timeStamp=now();this[expando]=true;};function returnFalse(){return false;}
function returnTrue(){return true;}
jQuery.Event.prototype={preventDefault:function(){this.isDefaultPrevented=returnTrue;var e=this.originalEvent;if(!e)
return;if(e.preventDefault)
e.preventDefault();e.returnValue=false;},stopPropagation:function(){this.isPropagationStopped=returnTrue;var e=this.originalEvent;if(!e)
return;if(e.stopPropagation)
e.stopPropagation();e.cancelBubble=true;},stopImmediatePropagation:function(){this.isImmediatePropagationStopped=returnTrue;this.stopPropagation();},isDefaultPrevented:returnFalse,isPropagationStopped:returnFalse,isImmediatePropagationStopped:returnFalse};var withinElement=function(event){var parent=event.relatedTarget;while(parent&&parent!=this)
try{parent=parent.parentNode;}
catch(e){parent=this;}
if(parent!=this){event.type=event.data;jQuery.event.handle.apply(this,arguments);}};jQuery.each({mouseover:'mouseenter',mouseout:'mouseleave'},function(orig,fix){jQuery.event.special[fix]={setup:function(){jQuery.event.add(this,orig,withinElement,fix);},teardown:function(){jQuery.event.remove(this,orig,withinElement);}};});jQuery.fn.extend({bind:function(type,data,fn){return type=="unload"?this.one(type,data,fn):this.each(function(){jQuery.event.add(this,type,fn||data,fn&&data);});},one:function(type,data,fn){var one=jQuery.event.proxy(fn||data,function(event){jQuery(this).unbind(event,one);return(fn||data).apply(this,arguments);});return this.each(function(){jQuery.event.add(this,type,one,fn&&data);});},unbind:function(type,fn){return this.each(function(){jQuery.event.remove(this,type,fn);});},trigger:function(type,data){return this.each(function(){jQuery.event.trigger(type,data,this);});},triggerHandler:function(type,data){if(this[0]){var event=jQuery.Event(type);event.preventDefault();event.stopPropagation();jQuery.event.trigger(event,data,this[0]);return event.result;}},toggle:function(fn){var args=arguments,i=1;while(i<args.length)
jQuery.event.proxy(fn,args[i++]);return this.click(jQuery.event.proxy(fn,function(event){this.lastToggle=(this.lastToggle||0)%i;event.preventDefault();return args[this.lastToggle++].apply(this,arguments)||false;}));},hover:function(fnOver,fnOut){return this.mouseenter(fnOver).mouseleave(fnOut);},ready:function(fn){bindReady();if(jQuery.isReady)
fn.call(document,jQuery);else
jQuery.readyList.push(fn);return this;},live:function(type,fn){var proxy=jQuery.event.proxy(fn);proxy.guid+=this.selector+type;jQuery(document).bind(liveConvert(type,this.selector),this.selector,proxy);return this;},die:function(type,fn){jQuery(document).unbind(liveConvert(type,this.selector),fn?{guid:fn.guid+this.selector+type}:null);return this;}});function liveHandler(event){var check=RegExp("(^|\\.)"+event.type+"(\\.|$)"),stop=true,elems=[];jQuery.each(jQuery.data(this,"events").live||[],function(i,fn){if(check.test(fn.type)){var elem=jQuery(event.target).closest(fn.data)[0];if(elem)
elems.push({elem:elem,fn:fn});}});jQuery.each(elems,function(){if(this.fn.call(this.elem,event,this.fn.data)===false)
stop=false;});return stop;}
function liveConvert(type,selector){return["live",type,selector.replace(/\./g,"`").replace(/ /g,"|")].join(".");}
jQuery.extend({isReady:false,readyList:[],ready:function(){if(!jQuery.isReady){jQuery.isReady=true;if(jQuery.readyList){jQuery.each(jQuery.readyList,function(){this.call(document,jQuery);});jQuery.readyList=null;}
jQuery(document).triggerHandler("ready");}}});var readyBound=false;function bindReady(){if(readyBound)return;readyBound=true;if(document.addEventListener){document.addEventListener("DOMContentLoaded",function(){document.removeEventListener("DOMContentLoaded",arguments.callee,false);jQuery.ready();},false);}else if(document.attachEvent){document.attachEvent("onreadystatechange",function(){if(document.readyState==="complete"){document.detachEvent("onreadystatechange",arguments.callee);jQuery.ready();}});if(document.documentElement.doScroll&&typeof window.frameElement==="undefined")(function(){if(jQuery.isReady)return;try{document.documentElement.doScroll("left");}catch(error){setTimeout(arguments.callee,0);return;}
jQuery.ready();})();}
jQuery.event.add(window,"load",jQuery.ready);}
jQuery.each(("blur,focus,load,resize,scroll,unload,click,dblclick,"+"mousedown,mouseup,mousemove,mouseover,mouseout,mouseenter,mouseleave,"+"change,select,submit,keydown,keypress,keyup,error").split(","),function(i,name){jQuery.fn[name]=function(fn){return fn?this.bind(name,fn):this.trigger(name);};});jQuery(window).bind('unload',function(){for(var id in jQuery.cache)
if(id!=1&&jQuery.cache[id].handle)
jQuery.event.remove(jQuery.cache[id].handle.elem);});(function(){jQuery.support={};var root=document.documentElement,script=document.createElement("script"),div=document.createElement("div"),id="script"+(new Date).getTime();div.style.display="none";div.innerHTML='   <link/><table></table><a href="/a" style="color:red;float:left;opacity:.5;">a</a><select><option>text</option></select><object><param/></object>';var all=div.getElementsByTagName("*"),a=div.getElementsByTagName("a")[0];if(!all||!all.length||!a){return;}
jQuery.support={leadingWhitespace:div.firstChild.nodeType==3,tbody:!div.getElementsByTagName("tbody").length,objectAll:!!div.getElementsByTagName("object")[0].getElementsByTagName("*").length,htmlSerialize:!!div.getElementsByTagName("link").length,style:/red/.test(a.getAttribute("style")),hrefNormalized:a.getAttribute("href")==="/a",opacity:a.style.opacity==="0.5",cssFloat:!!a.style.cssFloat,scriptEval:false,noCloneEvent:true,boxModel:null};script.type="text/javascript";try{script.appendChild(document.createTextNode("window."+id+"=1;"));}catch(e){}
root.insertBefore(script,root.firstChild);if(window[id]){jQuery.support.scriptEval=true;delete window[id];}
root.removeChild(script);if(div.attachEvent&&div.fireEvent){div.attachEvent("onclick",function(){jQuery.support.noCloneEvent=false;div.detachEvent("onclick",arguments.callee);});div.cloneNode(true).fireEvent("onclick");}
jQuery(function(){var div=document.createElement("div");div.style.width="1px";div.style.paddingLeft="1px";document.body.appendChild(div);jQuery.boxModel=jQuery.support.boxModel=div.offsetWidth===2;document.body.removeChild(div);});})();var styleFloat=jQuery.support.cssFloat?"cssFloat":"styleFloat";jQuery.props={"for":"htmlFor","class":"className","float":styleFloat,cssFloat:styleFloat,styleFloat:styleFloat,readonly:"readOnly",maxlength:"maxLength",cellspacing:"cellSpacing",rowspan:"rowSpan",tabindex:"tabIndex"};jQuery.fn.extend({_load:jQuery.fn.load,load:function(url,params,callback){if(typeof url!=="string")
return this._load(url);var off=url.indexOf(" ");if(off>=0){var selector=url.slice(off,url.length);url=url.slice(0,off);}
var type="GET";if(params)
if(jQuery.isFunction(params)){callback=params;params=null;}else if(typeof params==="object"){params=jQuery.param(params);type="POST";}
var self=this;jQuery.ajax({url:url,type:type,dataType:"html",data:params,complete:function(res,status){if(status=="success"||status=="notmodified")
self.html(selector?jQuery("<div/>").append(res.responseText.replace(/<script(.|\s)*?\/script>/g,"")).find(selector):res.responseText);if(callback)
self.each(callback,[res.responseText,status,res]);}});return this;},serialize:function(){return jQuery.param(this.serializeArray());},serializeArray:function(){return this.map(function(){return this.elements?jQuery.makeArray(this.elements):this;}).filter(function(){return this.name&&!this.disabled&&(this.checked||/select|textarea/i.test(this.nodeName)||/text|hidden|password/i.test(this.type));}).map(function(i,elem){var val=jQuery(this).val();return val==null?null:jQuery.isArray(val)?jQuery.map(val,function(val,i){return{name:elem.name,value:val};}):{name:elem.name,value:val};}).get();}});jQuery.each("ajaxStart,ajaxStop,ajaxComplete,ajaxError,ajaxSuccess,ajaxSend".split(","),function(i,o){jQuery.fn[o]=function(f){return this.bind(o,f);};});var jsc=now();jQuery.extend({get:function(url,data,callback,type){if(jQuery.isFunction(data)){callback=data;data=null;}
return jQuery.ajax({type:"GET",url:url,data:data,success:callback,dataType:type});},getScript:function(url,callback){return jQuery.get(url,null,callback,"script");},getJSON:function(url,data,callback){return jQuery.get(url,data,callback,"json");},post:function(url,data,callback,type){if(jQuery.isFunction(data)){callback=data;data={};}
return jQuery.ajax({type:"POST",url:url,data:data,success:callback,dataType:type});},ajaxSetup:function(settings){jQuery.extend(jQuery.ajaxSettings,settings);},ajaxSettings:{url:location.href,global:true,type:"GET",contentType:"application/x-www-form-urlencoded",processData:true,async:true,xhr:function(){return window.ActiveXObject?new ActiveXObject("Microsoft.XMLHTTP"):new XMLHttpRequest();},accepts:{xml:"application/xml, text/xml",html:"text/html",script:"text/javascript, application/javascript",json:"application/json, text/javascript",text:"text/plain",_default:"*/*"}},lastModified:{},ajax:function(s){s=jQuery.extend(true,s,jQuery.extend(true,{},jQuery.ajaxSettings,s));var jsonp,jsre=/=\?(&|$)/g,status,data,type=s.type.toUpperCase();if(s.data&&s.processData&&typeof s.data!=="string")
s.data=jQuery.param(s.data);if(s.dataType=="jsonp"){if(type=="GET"){if(!s.url.match(jsre))
s.url+=(s.url.match(/\?/)?"&":"?")+(s.jsonp||"callback")+"=?";}else if(!s.data||!s.data.match(jsre))
s.data=(s.data?s.data+"&":"")+(s.jsonp||"callback")+"=?";s.dataType="json";}
if(s.dataType=="json"&&(s.data&&s.data.match(jsre)||s.url.match(jsre))){jsonp="jsonp"+jsc++;if(s.data)
s.data=(s.data+"").replace(jsre,"="+jsonp+"$1");s.url=s.url.replace(jsre,"="+jsonp+"$1");s.dataType="script";window[jsonp]=function(tmp){data=tmp;success();complete();window[jsonp]=undefined;try{delete window[jsonp];}catch(e){}
if(head)
head.removeChild(script);};}
if(s.dataType=="script"&&s.cache==null)
s.cache=false;if(s.cache===false&&type=="GET"){var ts=now();var ret=s.url.replace(/(\?|&)_=.*?(&|$)/,"$1_="+ts+"$2");s.url=ret+((ret==s.url)?(s.url.match(/\?/)?"&":"?")+"_="+ts:"");}
if(s.data&&type=="GET"){s.url+=(s.url.match(/\?/)?"&":"?")+s.data;s.data=null;}
if(s.global&&!jQuery.active++)
jQuery.event.trigger("ajaxStart");var parts=/^(\w+:)?\/\/([^\/?#]+)/.exec(s.url);if(s.dataType=="script"&&type=="GET"&&parts&&(parts[1]&&parts[1]!=location.protocol||parts[2]!=location.host)){var head=document.getElementsByTagName("head")[0];var script=document.createElement("script");script.src=s.url;if(s.scriptCharset)
script.charset=s.scriptCharset;if(!jsonp){var done=false;script.onload=script.onreadystatechange=function(){if(!done&&(!this.readyState||this.readyState=="loaded"||this.readyState=="complete")){done=true;success();complete();head.removeChild(script);}};}
head.appendChild(script);return undefined;}
var requestDone=false;var xhr=s.xhr();if(s.username)
xhr.open(type,s.url,s.async,s.username,s.password);else
xhr.open(type,s.url,s.async);try{if(s.data)
xhr.setRequestHeader("Content-Type",s.contentType);if(s.ifModified)
xhr.setRequestHeader("If-Modified-Since",jQuery.lastModified[s.url]||"Thu, 01 Jan 1970 00:00:00 GMT");xhr.setRequestHeader("X-Requested-With","XMLHttpRequest");xhr.setRequestHeader("Accept",s.dataType&&s.accepts[s.dataType]?s.accepts[s.dataType]+", */*":s.accepts._default);}catch(e){}
if(s.beforeSend&&s.beforeSend(xhr,s)===false){if(s.global&&!--jQuery.active)
jQuery.event.trigger("ajaxStop");xhr.abort();return false;}
if(s.global)
jQuery.event.trigger("ajaxSend",[xhr,s]);var onreadystatechange=function(isTimeout){if(xhr.readyState==0){if(ival){clearInterval(ival);ival=null;if(s.global&&!--jQuery.active)
jQuery.event.trigger("ajaxStop");}}else if(!requestDone&&xhr&&(xhr.readyState==4||isTimeout=="timeout")){requestDone=true;if(ival){clearInterval(ival);ival=null;}
status=isTimeout=="timeout"?"timeout":!jQuery.httpSuccess(xhr)?"error":s.ifModified&&jQuery.httpNotModified(xhr,s.url)?"notmodified":"success";if(status=="success"){try{data=jQuery.httpData(xhr,s.dataType,s);}catch(e){status="parsererror";}}
if(status=="success"){var modRes;try{modRes=xhr.getResponseHeader("Last-Modified");}catch(e){}
if(s.ifModified&&modRes)
jQuery.lastModified[s.url]=modRes;if(!jsonp)
success();}else
jQuery.handleError(s,xhr,status);complete();if(isTimeout)
xhr.abort();if(s.async)
xhr=null;}};if(s.async){var ival=setInterval(onreadystatechange,13);if(s.timeout>0)
setTimeout(function(){if(xhr&&!requestDone)
onreadystatechange("timeout");},s.timeout);}
try{xhr.send(s.data);}catch(e){jQuery.handleError(s,xhr,null,e);}
if(!s.async)
onreadystatechange();function success(){if(s.success)
s.success(data,status);if(s.global)
jQuery.event.trigger("ajaxSuccess",[xhr,s]);}
function complete(){if(s.complete)
s.complete(xhr,status);if(s.global)
jQuery.event.trigger("ajaxComplete",[xhr,s]);if(s.global&&!--jQuery.active)
jQuery.event.trigger("ajaxStop");}
return xhr;},handleError:function(s,xhr,status,e){if(s.error)s.error(xhr,status,e);if(s.global)
jQuery.event.trigger("ajaxError",[xhr,s,e]);},active:0,httpSuccess:function(xhr){try{return!xhr.status&&location.protocol=="file:"||(xhr.status>=200&&xhr.status<300)||xhr.status==304||xhr.status==1223;}catch(e){}
return false;},httpNotModified:function(xhr,url){try{var xhrRes=xhr.getResponseHeader("Last-Modified");return xhr.status==304||xhrRes==jQuery.lastModified[url];}catch(e){}
return false;},httpData:function(xhr,type,s){var ct=xhr.getResponseHeader("content-type"),xml=type=="xml"||!type&&ct&&ct.indexOf("xml")>=0,data=xml?xhr.responseXML:xhr.responseText;if(xml&&data.documentElement.tagName=="parsererror")
throw"parsererror";if(s&&s.dataFilter)
data=s.dataFilter(data,type);if(typeof data==="string"){if(type=="script")
jQuery.globalEval(data);if(type=="json")
data=window["eval"]("("+data+")");}
return data;},param:function(a){var s=[];function add(key,value){s[s.length]=encodeURIComponent(key)+'='+encodeURIComponent(value);};if(jQuery.isArray(a)||a.jquery)
jQuery.each(a,function(){add(this.name,this.value);});else
for(var j in a)
if(jQuery.isArray(a[j]))
jQuery.each(a[j],function(){add(j,this);});else
add(j,jQuery.isFunction(a[j])?a[j]():a[j]);return s.join("&").replace(/%20/g,"+");}});var elemdisplay={},timerId,fxAttrs=[["height","marginTop","marginBottom","paddingTop","paddingBottom"],["width","marginLeft","marginRight","paddingLeft","paddingRight"],["opacity"]];function genFx(type,num){var obj={};jQuery.each(fxAttrs.concat.apply([],fxAttrs.slice(0,num)),function(){obj[this]=type;});return obj;}
jQuery.fn.extend({show:function(speed,callback){if(speed){return this.animate(genFx("show",3),speed,callback);}else{for(var i=0,l=this.length;i<l;i++){var old=jQuery.data(this[i],"olddisplay");this[i].style.display=old||"";if(jQuery.css(this[i],"display")==="none"){var tagName=this[i].tagName,display;if(elemdisplay[tagName]){display=elemdisplay[tagName];}else{var elem=jQuery("<"+tagName+" />").appendTo("body");display=elem.css("display");if(display==="none")
display="block";elem.remove();elemdisplay[tagName]=display;}
this[i].style.display=jQuery.data(this[i],"olddisplay",display);}}
return this;}},hide:function(speed,callback){if(speed){return this.animate(genFx("hide",3),speed,callback);}else{for(var i=0,l=this.length;i<l;i++){var old=jQuery.data(this[i],"olddisplay");if(!old&&old!=="none")
jQuery.data(this[i],"olddisplay",jQuery.css(this[i],"display"));this[i].style.display="none";}
return this;}},_toggle:jQuery.fn.toggle,toggle:function(fn,fn2){var bool=typeof fn==="boolean";return jQuery.isFunction(fn)&&jQuery.isFunction(fn2)?this._toggle.apply(this,arguments):fn==null||bool?this.each(function(){var state=bool?fn:jQuery(this).is(":hidden");jQuery(this)[state?"show":"hide"]();}):this.animate(genFx("toggle",3),fn,fn2);},fadeTo:function(speed,to,callback){return this.animate({opacity:to},speed,callback);},animate:function(prop,speed,easing,callback){var optall=jQuery.speed(speed,easing,callback);return this[optall.queue===false?"each":"queue"](function(){var opt=jQuery.extend({},optall),p,hidden=this.nodeType==1&&jQuery(this).is(":hidden"),self=this;for(p in prop){if(prop[p]=="hide"&&hidden||prop[p]=="show"&&!hidden)
return opt.complete.call(this);if((p=="height"||p=="width")&&this.style){opt.display=jQuery.css(this,"display");opt.overflow=this.style.overflow;}}
if(opt.overflow!=null)
this.style.overflow="hidden";opt.curAnim=jQuery.extend({},prop);jQuery.each(prop,function(name,val){var e=new jQuery.fx(self,opt,name);if(/toggle|show|hide/.test(val))
e[val=="toggle"?hidden?"show":"hide":val](prop);else{var parts=val.toString().match(/^([+-]=)?([\d+-.]+)(.*)$/),start=e.cur(true)||0;if(parts){var end=parseFloat(parts[2]),unit=parts[3]||"px";if(unit!="px"){self.style[name]=(end||1)+unit;start=((end||1)/e.cur(true))*start;self.style[name]=start+unit;}
if(parts[1])
end=((parts[1]=="-="?-1:1)*end)+start;e.custom(start,end,unit);}else
e.custom(start,val,"");}});return true;});},stop:function(clearQueue,gotoEnd){var timers=jQuery.timers;if(clearQueue)
this.queue([]);this.each(function(){for(var i=timers.length-1;i>=0;i--)
if(timers[i].elem==this){if(gotoEnd)
timers[i](true);timers.splice(i,1);}});if(!gotoEnd)
this.dequeue();return this;}});jQuery.each({slideDown:genFx("show",1),slideUp:genFx("hide",1),slideToggle:genFx("toggle",1),fadeIn:{opacity:"show"},fadeOut:{opacity:"hide"}},function(name,props){jQuery.fn[name]=function(speed,callback){return this.animate(props,speed,callback);};});jQuery.extend({speed:function(speed,easing,fn){var opt=typeof speed==="object"?speed:{complete:fn||!fn&&easing||jQuery.isFunction(speed)&&speed,duration:speed,easing:fn&&easing||easing&&!jQuery.isFunction(easing)&&easing};opt.duration=jQuery.fx.off?0:typeof opt.duration==="number"?opt.duration:jQuery.fx.speeds[opt.duration]||jQuery.fx.speeds._default;opt.old=opt.complete;opt.complete=function(){if(opt.queue!==false)
jQuery(this).dequeue();if(jQuery.isFunction(opt.old))
opt.old.call(this);};return opt;},easing:{linear:function(p,n,firstNum,diff){return firstNum+diff*p;},swing:function(p,n,firstNum,diff){return((-Math.cos(p*Math.PI)/2)+0.5)*diff+firstNum;}},timers:[],fx:function(elem,options,prop){this.options=options;this.elem=elem;this.prop=prop;if(!options.orig)
options.orig={};}});jQuery.fx.prototype={update:function(){if(this.options.step)
this.options.step.call(this.elem,this.now,this);(jQuery.fx.step[this.prop]||jQuery.fx.step._default)(this);if((this.prop=="height"||this.prop=="width")&&this.elem.style)
this.elem.style.display="block";},cur:function(force){if(this.elem[this.prop]!=null&&(!this.elem.style||this.elem.style[this.prop]==null))
return this.elem[this.prop];var r=parseFloat(jQuery.css(this.elem,this.prop,force));return r&&r>-10000?r:parseFloat(jQuery.curCSS(this.elem,this.prop))||0;},custom:function(from,to,unit){this.startTime=now();this.start=from;this.end=to;this.unit=unit||this.unit||"px";this.now=this.start;this.pos=this.state=0;var self=this;function t(gotoEnd){return self.step(gotoEnd);}
t.elem=this.elem;if(t()&&jQuery.timers.push(t)==1){timerId=setInterval(function(){var timers=jQuery.timers;for(var i=0;i<timers.length;i++)
if(!timers[i]())
timers.splice(i--,1);if(!timers.length){clearInterval(timerId);}},13);}},show:function(){this.options.orig[this.prop]=jQuery.attr(this.elem.style,this.prop);this.options.show=true;this.custom(this.prop=="width"||this.prop=="height"?1:0,this.cur());jQuery(this.elem).show();},hide:function(){this.options.orig[this.prop]=jQuery.attr(this.elem.style,this.prop);this.options.hide=true;this.custom(this.cur(),0);},step:function(gotoEnd){var t=now();if(gotoEnd||t>=this.options.duration+this.startTime){this.now=this.end;this.pos=this.state=1;this.update();this.options.curAnim[this.prop]=true;var done=true;for(var i in this.options.curAnim)
if(this.options.curAnim[i]!==true)
done=false;if(done){if(this.options.display!=null){this.elem.style.overflow=this.options.overflow;this.elem.style.display=this.options.display;if(jQuery.css(this.elem,"display")=="none")
this.elem.style.display="block";}
if(this.options.hide)
jQuery(this.elem).hide();if(this.options.hide||this.options.show)
for(var p in this.options.curAnim)
jQuery.attr(this.elem.style,p,this.options.orig[p]);this.options.complete.call(this.elem);}
return false;}else{var n=t-this.startTime;this.state=n/this.options.duration;this.pos=jQuery.easing[this.options.easing||(jQuery.easing.swing?"swing":"linear")](this.state,n,0,1,this.options.duration);this.now=this.start+((this.end-this.start)*this.pos);this.update();}
return true;}};jQuery.extend(jQuery.fx,{speeds:{slow:600,fast:200,_default:400},step:{opacity:function(fx){jQuery.attr(fx.elem.style,"opacity",fx.now);},_default:function(fx){if(fx.elem.style&&fx.elem.style[fx.prop]!=null)
fx.elem.style[fx.prop]=fx.now+fx.unit;else
fx.elem[fx.prop]=fx.now;}}});if(document.documentElement["getBoundingClientRect"])
jQuery.fn.offset=function(){if(!this[0])return{top:0,left:0};if(this[0]===this[0].ownerDocument.body)return jQuery.offset.bodyOffset(this[0]);var box=this[0].getBoundingClientRect(),doc=this[0].ownerDocument,body=doc.body,docElem=doc.documentElement,clientTop=docElem.clientTop||body.clientTop||0,clientLeft=docElem.clientLeft||body.clientLeft||0,top=box.top+(self.pageYOffset||jQuery.boxModel&&docElem.scrollTop||body.scrollTop)-clientTop,left=box.left+(self.pageXOffset||jQuery.boxModel&&docElem.scrollLeft||body.scrollLeft)-clientLeft;return{top:top,left:left};};else
jQuery.fn.offset=function(){if(!this[0])return{top:0,left:0};if(this[0]===this[0].ownerDocument.body)return jQuery.offset.bodyOffset(this[0]);jQuery.offset.initialized||jQuery.offset.initialize();var elem=this[0],offsetParent=elem.offsetParent,prevOffsetParent=elem,doc=elem.ownerDocument,computedStyle,docElem=doc.documentElement,body=doc.body,defaultView=doc.defaultView,prevComputedStyle=defaultView.getComputedStyle(elem,null),top=elem.offsetTop,left=elem.offsetLeft;while((elem=elem.parentNode)&&elem!==body&&elem!==docElem){computedStyle=defaultView.getComputedStyle(elem,null);top-=elem.scrollTop,left-=elem.scrollLeft;if(elem===offsetParent){top+=elem.offsetTop,left+=elem.offsetLeft;if(jQuery.offset.doesNotAddBorder&&!(jQuery.offset.doesAddBorderForTableAndCells&&/^t(able|d|h)$/i.test(elem.tagName)))
top+=parseInt(computedStyle.borderTopWidth,10)||0,left+=parseInt(computedStyle.borderLeftWidth,10)||0;prevOffsetParent=offsetParent,offsetParent=elem.offsetParent;}
if(jQuery.offset.subtractsBorderForOverflowNotVisible&&computedStyle.overflow!=="visible")
top+=parseInt(computedStyle.borderTopWidth,10)||0,left+=parseInt(computedStyle.borderLeftWidth,10)||0;prevComputedStyle=computedStyle;}
if(prevComputedStyle.position==="relative"||prevComputedStyle.position==="static")
top+=body.offsetTop,left+=body.offsetLeft;if(prevComputedStyle.position==="fixed")
top+=Math.max(docElem.scrollTop,body.scrollTop),left+=Math.max(docElem.scrollLeft,body.scrollLeft);return{top:top,left:left};};jQuery.offset={initialize:function(){if(this.initialized)return;var body=document.body,container=document.createElement('div'),innerDiv,checkDiv,table,td,rules,prop,bodyMarginTop=body.style.marginTop,html='<div style="position:absolute;top:0;left:0;margin:0;border:5px solid #000;padding:0;width:1px;height:1px;"><div></div></div><table style="position:absolute;top:0;left:0;margin:0;border:5px solid #000;padding:0;width:1px;height:1px;" cellpadding="0" cellspacing="0"><tr><td></td></tr></table>';rules={position:'absolute',top:0,left:0,margin:0,border:0,width:'1px',height:'1px',visibility:'hidden'};for(prop in rules)container.style[prop]=rules[prop];container.innerHTML=html;body.insertBefore(container,body.firstChild);innerDiv=container.firstChild,checkDiv=innerDiv.firstChild,td=innerDiv.nextSibling.firstChild.firstChild;this.doesNotAddBorder=(checkDiv.offsetTop!==5);this.doesAddBorderForTableAndCells=(td.offsetTop===5);innerDiv.style.overflow='hidden',innerDiv.style.position='relative';this.subtractsBorderForOverflowNotVisible=(checkDiv.offsetTop===-5);body.style.marginTop='1px';this.doesNotIncludeMarginInBodyOffset=(body.offsetTop===0);body.style.marginTop=bodyMarginTop;body.removeChild(container);this.initialized=true;},bodyOffset:function(body){jQuery.offset.initialized||jQuery.offset.initialize();var top=body.offsetTop,left=body.offsetLeft;if(jQuery.offset.doesNotIncludeMarginInBodyOffset)
top+=parseInt(jQuery.curCSS(body,'marginTop',true),10)||0,left+=parseInt(jQuery.curCSS(body,'marginLeft',true),10)||0;return{top:top,left:left};}};jQuery.fn.extend({position:function(){var left=0,top=0,results;if(this[0]){var offsetParent=this.offsetParent(),offset=this.offset(),parentOffset=/^body|html$/i.test(offsetParent[0].tagName)?{top:0,left:0}:offsetParent.offset();offset.top-=num(this,'marginTop');offset.left-=num(this,'marginLeft');parentOffset.top+=num(offsetParent,'borderTopWidth');parentOffset.left+=num(offsetParent,'borderLeftWidth');results={top:offset.top-parentOffset.top,left:offset.left-parentOffset.left};}
return results;},offsetParent:function(){var offsetParent=this[0].offsetParent||document.body;while(offsetParent&&(!/^body|html$/i.test(offsetParent.tagName)&&jQuery.css(offsetParent,'position')=='static'))
offsetParent=offsetParent.offsetParent;return jQuery(offsetParent);}});jQuery.each(['Left','Top'],function(i,name){var method='scroll'+name;jQuery.fn[method]=function(val){if(!this[0])return null;return val!==undefined?this.each(function(){this==window||this==document?window.scrollTo(!i?val:jQuery(window).scrollLeft(),i?val:jQuery(window).scrollTop()):this[method]=val;}):this[0]==window||this[0]==document?self[i?'pageYOffset':'pageXOffset']||jQuery.boxModel&&document.documentElement[method]||document.body[method]:this[0][method];};});jQuery.each(["Height","Width"],function(i,name){var tl=i?"Left":"Top",br=i?"Right":"Bottom";jQuery.fn["inner"+name]=function(){return this[name.toLowerCase()]()+
num(this,"padding"+tl)+
num(this,"padding"+br);};jQuery.fn["outer"+name]=function(margin){return this["inner"+name]()+
num(this,"border"+tl+"Width")+
num(this,"border"+br+"Width")+
(margin?num(this,"margin"+tl)+num(this,"margin"+br):0);};var type=name.toLowerCase();jQuery.fn[type]=function(size){return this[0]==window?document.compatMode=="CSS1Compat"&&document.documentElement["client"+name]||document.body["client"+name]:this[0]==document?Math.max(document.documentElement["client"+name],document.body["scroll"+name],document.documentElement["scroll"+name],document.body["offset"+name],document.documentElement["offset"+name]):size===undefined?(this.length?jQuery.css(this[0],type):null):this.css(type,typeof size==="string"?size:size+"px");};});})();function tooltip(tipObj){var positionLeft=-30;var positionTop=-5;var appearanceTime=250;var thisObj=this;thisObj.sticky=false;if(tipObj.className=='tooltip_sticky'){thisObj.sticky=true;positionLeft=-30;positionTop=-5;appearanceTime=250;thisObj.tooltippLayerObj=getElementByIdWithCache('tooltip');thisObj.tooltippTextObj=getElementByIdWithCache('tooltipBody');}else{thisObj.sticky=false;positionLeft=0;positionTop=10;appearanceTime=250;thisObj.tooltippLayerObj=getElementByIdWithCache('tooltipPlain');thisObj.tooltippTextObj=getElementByIdWithCache('tooltipBodyPlain');}
thisObj.tipObj=tipObj;thisObj.stickyActivated=false;this.waitForTooltip=function(){thisObj.timeout=setTimeout(thisObj.showTooltip,appearanceTime);}
this.showTooltip=function(){thisObj.tooltippTextObj.innerHTML=thisObj.tipObj.innerHTML;thisObj.tooltippLayerObj.style.position='absolute';thisObj.tooltippLayerObj.style.left='-1000px';thisObj.tooltippLayerObj.style.top='-1000px';thisObj.tooltippLayerObj.style.display='block';posX=(thisObj.xPos+positionLeft);posY=(thisObj.yPos+positionTop);if(window.innerWidth){screenX=window.innerWidth+window.pageXOffset-thisObj.tooltippLayerObj.offsetWidth-20;screenY=window.innerHeight+window.pageYOffset-thisObj.tooltippLayerObj.offsetHeight-20;}else if(document.documentElement.clientWidth){screenX=document.documentElement.clientWidth+document.documentElement.scrollLeft-thisObj.tooltippLayerObj.offsetWidth-20;screenY=document.documentElement.clientHeight+document.documentElement.scrollTop-thisObj.tooltippLayerObj.offsetHeight-20;}else{screenX=1000;screenY=700;}
if(posX>screenX){posX=thisObj.xPos-thisObj.tooltippLayerObj.offsetWidth;}
if(posY>screenY){posY=thisObj.yPos-thisObj.tooltippLayerObj.offsetHeight;}
thisObj.tooltippLayerObj.style.left=posX+'px';thisObj.tooltippLayerObj.style.top=posY+'px';if(thisObj.sticky){if(!thisObj.stickyActivated){thisObj.stickyActivated=true;addListener(thisObj.tooltippLayerObj,'mouseover',function(ev){thisObj.tooltippLayerObj.style.display='block';});addListener(thisObj.tooltippLayerObj,'mouseout',function(ev){thisObj.hideTooltip();});}}}
this.hideTooltip=function(){if(thisObj.timeout){window.clearTimeout(thisObj.timeout);}
thisObj.tooltippLayerObj.style.display='none';}
this.getIEBody=function(){return(window.document.compatMode=="CSS1Compat")?window.document.documentElement:window.document.body||null;}
thisObj.IEBody=thisObj.getIEBody();addListener(thisObj.tipObj.parentNode,'mouseover',function(ev){thisObj.waitForTooltip();});addListener(thisObj.tipObj.parentNode,'mousemove',function(ev){thisObj.xPos=isNaN(ev.pageX)?parseInt(window.event.clientX+thisObj.IEBody.scrollLeft):parseInt(ev.pageX);thisObj.yPos=isNaN(ev.pageY)?parseInt(window.event.clientY+thisObj.IEBody.scrollTop)+10:parseInt(ev.pageY)+10;});addListener(thisObj.tipObj.parentNode,'mouseout',function(){thisObj.hideTooltip();});}
function display_info(type)
{if
(document.getElementById("infoInput").innerHTML==""||document.getElementById("infoInput").innerHTML!=get_displayText(type))
{document.getElementById("infoInput").innerHTML=get_displayText(type);}}
function display_error(type)
{if
(document.getElementById("errorInput").innerHTML==""||document.getElementById("errorInput").innerHTML!=get_errorText(type))
{document.getElementById("errorInput").innerHTML=get_errorText(type);document.getElementById("error").style.display="block";}}
function hide_error(type)
{document.getElementById("errorInput").innerHTML="";document.getElementById("error").style.display="none";}
function checkUsername()
{var username=document.forms['new'].elements['username'].value;if(username.length<3||username.length>=20)
{display_error("username");}
else
{hide_error();}}
function checkEmail()
{var email=document.forms['new'].elements['email'].value;validate=email.match(/[a-zA-Z0-9]+@+[a-zA-Z0-9]+[.]+[a-zA-Z0-9]{2,4}/);if(email.length<3||email.length>=64||!validate)
{display_error("email");}
else
{hide_error();}}
﻿
(function($){$.fn.hoverIntent=function(f,g){var cfg={sensitivity:7,interval:100,timeout:0};cfg=$.extend(cfg,g?{over:f,out:g}:f);var cX,cY,pX,pY;var track=function(ev){cX=ev.pageX;cY=ev.pageY;};var compare=function(ev,ob){ob.hoverIntent_t=clearTimeout(ob.hoverIntent_t);if((Math.abs(pX-cX)+Math.abs(pY-cY))<cfg.sensitivity){$(ob).unbind("mousemove",track);ob.hoverIntent_s=1;return cfg.over.apply(ob,[ev]);}else{pX=cX;pY=cY;ob.hoverIntent_t=setTimeout(function(){compare(ev,ob);},cfg.interval);}};var delay=function(ev,ob){ob.hoverIntent_t=clearTimeout(ob.hoverIntent_t);ob.hoverIntent_s=0;return cfg.out.apply(ob,[ev]);};var handleHover=function(e){var p=(e.type=="mouseover"?e.fromElement:e.toElement)||e.relatedTarget;while(p&&p!=this){try{p=p.parentNode;}catch(e){p=this;}}
if(p==this){return false;}
var ev=jQuery.extend({},e);var ob=this;if(ob.hoverIntent_t){ob.hoverIntent_t=clearTimeout(ob.hoverIntent_t);}
if(e.type=="mouseover"){pX=ev.pageX;pY=ev.pageY;$(ob).bind("mousemove",track);if(ob.hoverIntent_s!=1){ob.hoverIntent_t=setTimeout(function(){compare(ev,ob);},cfg.interval);}}else{$(ob).unbind("mousemove",track);if(ob.hoverIntent_s==1){ob.hoverIntent_t=setTimeout(function(){delay(ev,ob);},cfg.timeout);}}};return this.mouseover(handleHover).mouseout(handleHover);};})(jQuery);function t(){v=new Date();n=new Date();o=new Date();for(cn=1;cn<=anz;cn++){bxx=document.getElementById('bxx'+cn);ss=bxx.title;s=ss-Math.round((n.getTime()-v.getTime())/1000.);m=0;h=0;if(s<0){bxx.innerHTML="-";}else{if(s>59){m=Math.floor(s/60);s=s-m*60;}
if(m>59){h=Math.floor(m/60);m=m-h*60;}
if(s<10){s="0"+s;}
if(m<10){m="0"+m;}
bxx.innerHTML=h+":"+m+":"+s+"";}
bxx.title=bxx.title-1;}
window.setTimeout("t();",999);}
var x="";var e=null;function cntchar(m){if(window.document.forms[0].text.value.length>m){window.document.forms[0].text.value=x;}else{x=window.document.forms[0].text.value;}
if(e==null){e=document.getElementById('cntChars');}else{e.childNodes[0].data=window.document.forms[0].text.value.length;}}
function popupWindow(target_url,win_name,scrollbars,menubar,top,left,toolbar,width,height,resizable){var new_win=window.open(target_url,win_name,'scrollbars=yes,menubar='+menubar+',top='+top+',left='+left+',toolbar='+toolbar+',width='+width+',height='+height+',resizable='+resizable+'');new_win.focus();}
function fenster(target_url,win_name){var new_win=window.open(target_url,win_name,'scrollbars=yes,menubar=no,top=0,left=0,toolbar=no,width=550,height=280,resizable=yes');new_win.focus();}
function fenstered(target_url,win_name){var new_win=window.open(target_url,win_name,'scrollbars=yes,menubar=no,top=0,left=0,toolbar=no,width=550,height=280,resizable=yes');new_win.focus();}
function haha(z1){eval("location='"+z1.options[z1.selectedIndex].value+"'");}
function tb_open(url)
{tb_show(null,url,false);}
function tb_remove_openNew(url)
{tb_remove();setTimeout("tb_open_new('"+url+"')",500);}
function tb_remove_iframe(e){e=!e?event:e;tastenCode=e.keyCode?e.keyCode:e.which;if(tastenCode==27)self.parent.tb_remove();}
function link_to_gamepay(){document.getElementsByName("lang");document.getElementsByName("name");document.getElementsByName("playerid");document.getElementsByName("checksum");document.getElementsByName("session");}
function showGalaxy(galaxy,system,planet){if(typeof window.opener=="undefined"||window.opener==null){document.location.href="index.php?page=galaxy&no_header=1&galaxy="+galaxy+"&system="+system+"&planet="+planet+"&session="+session;}else{window.opener.document.location.href="index.php?page=galaxy&no_header=1&galaxy="+galaxy+"&system="+system+"&planet="+planet+"&session="+session;}}
function showRenamePlanet(planetID){if(typeof window.opener=="undefined"||window.opener==null){document.location.href="index.php?page=renameplanet&session="+session+"&pl="+planetID;}else{window.opener.document.location.href="index.php?page=renameplanet&session="+session+"&pl="+planetID;}}
function showFleetMenu(galaxy,system,planet,planettype,missiontype){if(typeof window.opener=="undefined"||window.opener==null){document.location.href="index.php?page=flotten1&session="+session+"&galaxy="+galaxy+"&system="+system+"&planet="+planet+"&planettype="+planettype+"&target_mission="+missiontype;}else{window.opener.document.location.href="index.php?page=flotten1&session="+session+"&galaxy="+galaxy+"&system="+system+"&planet="+planet+"&planettype="+planettype+"&target_mission="+missiontype;}}
function showMessageMenu(targetID){if(typeof window.opener=="undefined"||window.opener==null){document.location.href="index.php?page=writemessages&session="+session+"&messageziel="+targetID;}else{window.opener.document.location.href="index.php?page=writemessages&session="+session+"&messageziel="+targetID;}}
function submitOnEnter(ev)
{var keyCode;if(window.event)
{keyCode=window.event.keyCode;}
else if(ev)
{keyCode=ev.which;}
else
{return true;}
if(keyCode==13)
{trySubmit();return false;}
else
{return true;}}
function show_hide_tr(ele)
{if(document.getElementById(ele).style.display=="none")
{document.getElementById(ele).style.display="block";}
else
{document.getElementById(ele).style.display="none";}}
function setMaxIntInput(data)
{for(var techID in data){if(!$("#ship_"+techID).attr("disabled")){$("#ship_"+techID).val(data[techID]);checkIntInput("ship_"+techID,0,data[techID]);}}}
function clearInput(id)
{$("#"+id).val("");}
function setTemplate(dataTpl,dataMax)
{for(var techID in dataTpl){if(!$("#ship_"+techID).attr("disabled")){$("#ship_"+techID).val(dataTpl[techID]);}
if(typeof dataMax[techID]=="undefined"){dataMax[techID]=0;}
checkIntInput("ship_"+techID,0,dataMax[techID]);}}
function checkIntInput(id,minVal,maxVal)
{value=$("#"+id).val();if(value!=""){intVal=trimInteger(value);intVal=parseInt(value);intVal=(isNaN(intVal)||intVal==0)?minVal:intVal;intVal=Math.abs(intVal);if(maxVal!=null){intVal=Math.min(intVal,maxVal);}
$("#"+id).val(intVal);}}
function initCluetip(){$('*.tips').cluetip({splitTitle:'|',showTitle:false,width:150,positionBy:'auto',leftOffset:20,topOffset:15,cluezIndex:9997,hoverIntent:{sensitivity:1,interval:250,timeout:400}});$('*.tips2').cluetip({splitTitle:'|',showTitle:true,cluetipClass:'event',positionBy:'mouse',leftOffset:15,topOffset:10,width:'200'});$('*.tips3').cluetip({splitTitle:'|',showTitle:true,cluetipClass:'advice',positionBy:'fixed',leftOffset:25,topOffset:25});$('*.tips4').cluetip({splitTitle:'|',showTitle:true,cluetipClass:'impact',positionBy:'fixed',width:125,leftOffset:10,topOffset:10});$('*.tips5').cluetip({splitTitle:'|',showTitle:false,cluetipClass:'impact2',positionBy:'fixed',width:100,leftOffset:10,topOffset:5});$('*.spyshare').cluetip({sticky:true,closePosition:'bottom',closeText:'<img src="img/navigation/close-details.jpg">',truncate:60});$('*.basic2').cluetip({local:true,closePosition:'title',closeText:'<img src="img/navigation/close-details.jpg">',cluetipClass:'event',width:200,positionBy:'fixed',leftOffset:25,topOffset:0,showTitle:false,sticky:true,arrows:true});$('*.demolishcosts').cluetip({local:true,cluetipClass:'impact',width:150,positionBy:'bottomTop',leftOffset:15,topOffset:15});$('*.techinfoDetails').cluetip({local:true,width:250,showTitle:false,leftOffset:5});$('*.TTgalaxy').cluetip({local:true,cluetipClass:'galaxy',width:250,showTitle:false,sticky:true,mouseOutClose:true,hoverIntent:false});}
function initCluetipEventlist(){$('*.tips').cluetip({splitTitle:'|',showTitle:false,width:150,positionBy:'mouse',leftOffset:20,topOffset:10,cluezIndex:9997,hoverIntent:{sensitivity:3,interval:150,timeout:700}});$('*.basic').cluetip({local:true,closePosition:'title',closeText:'<img src="img/navigation/close-details.jpg">',cluetipClass:'event',positionBy:'fixed',leftOffset:25,topOffset:0,sticky:true,arrows:true});$('*.tips2').cluetip({splitTitle:'|',showTitle:false,width:150,positionBy:'mouse',leftOffset:30,topOffset:30,cluezIndex:9997,hoverIntent:{interval:400,timeout:700}});}
function reloadCluetip(){$('*.reloadTips').cluetip({splitTitle:'|',showTitle:false,width:150,positionBy:'auto',leftOffset:20,topOffset:15,cluezIndex:9997,hoverIntent:{sensitivity:1,interval:250,timeout:400}});}
function AjaxCluetip(){$('*.ajaxTips').cluetip({splitTitle:'|',showTitle:false,width:150,positionBy:'auto',leftOffset:20,topOffset:15,cluezIndex:9997,hoverIntent:{sensitivity:1,interval:250,timeout:400}});$('*.ajaxTips2').cluetip({splitTitle:'|',showTitle:true,cluetipClass:'event',positionBy:'mouse',leftOffset:15,topOffset:10,width:'200'});}
jQuery.cookie=function(name,value,options){if(typeof value!='undefined'){options=options||{};if(value===null){value='';options.expires=-1;}var expires='';if(options.expires&&(typeof options.expires=='number'||options.expires.toUTCString)){var date;if(typeof options.expires=='number'){date=new Date();date.setTime(date.getTime()+(options.expires*24*60*60*1000));}else{date=options.expires;}expires='; expires='+date.toUTCString();}var path=options.path?'; path='+(options.path):'';var domain=options.domain?'; domain='+(options.domain):'';var secure=options.secure?'; secure':'';document.cookie=[name,'=',encodeURIComponent(value),expires,path,domain,secure].join('');}else{var cookieValue=null;if(document.cookie&&document.cookie!=''){var cookies=document.cookie.split(';');for(var i=0;i<cookies.length;i++){var cookie=jQuery.trim(cookies[i]);if(cookie.substring(0,name.length+1)==(name+'=')){cookieValue=decodeURIComponent(cookie.substring(name.length+1));break;}}}return cookieValue;}};;(function($){var $cluetip,$cluetipInner,$cluetipOuter,$cluetipTitle,$cluetipArrows,$dropShadow,imgCount;$.fn.cluetip=function(js,options){if(typeof js=='object'){options=js;js=null;}
return this.each(function(index){var $this=$(this);var opts=$.extend(false,{},$.fn.cluetip.defaults,options||{},$.metadata?$this.metadata():$.meta?$this.data():{});var cluetipContents=false;var cluezIndex=parseInt(opts.cluezIndex,10)-1;var isActive=false,closeOnDelay=0;if(!$('#cluetip').length){$cluetipInner=$('<div id="cluetip-inner"></div>');$cluetipTitle=$('<h3 id="cluetip-title"></h3>');$cluetipOuter=$('<div id="cluetip-outer"></div>').append($cluetipInner).prepend($cluetipTitle);$cluetip=$('<div id="cluetip"></div>').css({zIndex:opts.cluezIndex}).append($cluetipOuter).append('<div id="cluetip-extra"></div>')[insertionType](insertionElement).hide();$('<div id="cluetip-waitimage"></div>').css({position:'absolute',zIndex:cluezIndex-1}).insertBefore('#cluetip').hide();$cluetip.css({position:'absolute',zIndex:cluezIndex});$cluetipOuter.css({position:'relative',zIndex:cluezIndex+1});$cluetipArrows=$('<div id="cluetip-arrows" class="cluetip-arrows"></div>').css({zIndex:cluezIndex+1}).appendTo('#cluetip');}
var dropShadowSteps=(opts.dropShadow)?+opts.dropShadowSteps:0;if(!$dropShadow){$dropShadow=$([]);for(var i=0;i<dropShadowSteps;i++){$dropShadow=$dropShadow.add($('<div></div>').css({zIndex:cluezIndex-i-1,opacity:.1,top:1+i,left:1+i}));};$dropShadow.css({position:'absolute',backgroundColor:'#000'}).prependTo($cluetip);}
var tipAttribute=$this.attr(opts.attribute),ctClass=opts.cluetipClass;if(!tipAttribute&&!opts.splitTitle&&!js)return true;if(opts.local&&opts.hideLocal){$(tipAttribute+':first').hide();}
var tOffset=parseInt(opts.topOffset,10),lOffset=parseInt(opts.leftOffset,10);var tipHeight,wHeight;var defHeight=isNaN(parseInt(opts.height,10))?'auto':(/\D/g).test(opts.height)?opts.height:opts.height+'px';var sTop,linkTop,posY,tipY,mouseY,baseline;var tipInnerWidth=isNaN(parseInt(opts.width,10))?275:parseInt(opts.width,10);var tipWidth=tipInnerWidth+(parseInt($cluetip.css('paddingLeft'))||0)+(parseInt($cluetip.css('paddingRight'))||0)+dropShadowSteps;var linkWidth=this.offsetWidth;var linkLeft,posX,tipX,mouseX,winWidth;var tipParts;var tipTitle=(opts.attribute!='title')?$this.attr(opts.titleAttribute):'';if(opts.splitTitle){if(tipTitle==undefined){tipTitle='';}
tipParts=tipTitle.split(opts.splitTitle);tipTitle=tipParts.shift();}
var localContent;var activate=function(event){if(!opts.onActivate($this)){return false;}
isActive=true;$cluetip.removeClass().css({width:tipInnerWidth});if(tipAttribute==$this.attr('href')){$this.css('cursor',opts.cursor);}
$this.attr('title','');if(opts.hoverClass){$this.addClass(opts.hoverClass);}
linkTop=posY=$this.offset().top;linkLeft=$this.offset().left;mouseX=event.pageX;mouseY=event.pageY;if($this[0].tagName.toLowerCase()!='area'){sTop=$(document).scrollTop();winWidth=$(window).width();}
if(opts.positionBy=='fixed'){posX=linkWidth+linkLeft+lOffset;$cluetip.css({left:posX});}else{posX=(linkWidth>linkLeft&&linkLeft>tipWidth)||linkLeft+linkWidth+tipWidth+lOffset>winWidth?linkLeft-tipWidth-lOffset:linkWidth+linkLeft+lOffset;if($this[0].tagName.toLowerCase()=='area'||opts.positionBy=='mouse'||linkWidth+tipWidth>winWidth){if(mouseX+20+tipWidth>winWidth){$cluetip.addClass(' cluetip-'+ctClass);posX=(mouseX-tipWidth-lOffset)>=0?mouseX-tipWidth-lOffset-parseInt($cluetip.css('marginLeft'),10)+parseInt($cluetipInner.css('marginRight'),10):mouseX-(tipWidth/2);}else{posX=mouseX+lOffset;}}
var pY=posX<0?event.pageY+tOffset:event.pageY;$cluetip.css({left:(posX>0&&opts.positionBy!='bottomTop')?posX:(mouseX+(tipWidth/2)>winWidth)?winWidth/2-tipWidth/2:Math.max(mouseX-(tipWidth/2),0)});}
wHeight=$(window).height();if(js){$cluetipInner.html(js);cluetipShow(pY);}
else if(tipParts){var tpl=tipParts.length;for(var i=0;i<tpl;i++){if(i==0){$cluetipInner.html(tipParts[i]);}else{$cluetipInner.append('<div class="split-body">'+tipParts[i]+'</div>');}};cluetipShow(pY);}
else if(!opts.local&&tipAttribute.indexOf('#')!=0){if(cluetipContents&&opts.ajaxCache){$cluetipInner.html(cluetipContents);cluetipShow(pY);}
else{var ajaxSettings=opts.ajaxSettings;ajaxSettings.url=tipAttribute;ajaxSettings.beforeSend=function(){$cluetipOuter.children().empty();if(opts.waitImage){$('#cluetip-waitimage').css({top:mouseY+20,left:mouseX+20}).show();}};ajaxSettings.error=function(){if(isActive){$cluetipInner.html('<i>sorry, the contents could not be loaded</i>');}};ajaxSettings.success=function(data){cluetipContents=opts.ajaxProcess(data);if(isActive){$cluetipInner.html(cluetipContents);}};ajaxSettings.complete=function(){imgCount=$('#cluetip-inner img').length;if(imgCount&&!$.browser.opera){$('#cluetip-inner img').load(function(){imgCount--;if(imgCount<1){$('#cluetip-waitimage').hide();if(isActive)cluetipShow(pY);}});}else{$('#cluetip-waitimage').hide();if(isActive)cluetipShow(pY);}};$.ajax(ajaxSettings);}}else if(opts.local){var $localContent=$(tipAttribute+':first');var localCluetip=$.fn.wrapInner?$localContent.wrapInner('<div></div>').children().clone(true):$localContent.html();$.fn.wrapInner?$cluetipInner.empty().append(localCluetip):$cluetipInner.html(localCluetip);cluetipShow(pY);}};var cluetipShow=function(bpY){$cluetip.addClass('cluetip-'+ctClass);if(opts.truncate){var $truncloaded=$cluetipInner.text().slice(0,opts.truncate)+'...';$cluetipInner.html($truncloaded);}
function doNothing(){};tipTitle?$cluetipTitle.show().html(tipTitle):(opts.showTitle)?$cluetipTitle.show().html('&nbsp;'):$cluetipTitle.hide();if(opts.sticky){var $closeLink=$('<div id="cluetip-close"><a href="#">'+opts.closeText+'</a></div>');(opts.closePosition=='bottom')?$closeLink.appendTo($cluetipInner):(opts.closePosition=='title')?$closeLink.prependTo($cluetipTitle):$closeLink.prependTo($cluetipInner);$closeLink.click(function(){cluetipClose();return false;});if(opts.mouseOutClose){if($.fn.hoverIntent&&opts.hoverIntent){$cluetip.hoverIntent({over:doNothing,timeout:opts.hoverIntent.timeout,out:function(){$closeLink.trigger('click');}});}else{$cluetip.hover(doNothing,function(){$closeLink.trigger('click');});}}else{$cluetip.unbind('mouseout');}}
var direction='';$cluetipOuter.css({overflow:defHeight=='auto'?'visible':'auto',height:defHeight});tipHeight=defHeight=='auto'?Math.max($cluetip.outerHeight(),$cluetip.height()):parseInt(defHeight,10);tipY=posY;baseline=sTop+wHeight;if(opts.positionBy=='fixed'){tipY=posY-opts.dropShadowSteps+tOffset;}else if((posX<mouseX&&Math.max(posX,0)+tipWidth>mouseX)||opts.positionBy=='bottomTop'){if(posY+tipHeight+tOffset>baseline&&mouseY-sTop>tipHeight+tOffset){tipY=mouseY-tipHeight-tOffset;direction='top';}else{tipY=mouseY+tOffset;direction='bottom';}}else if(posY+tipHeight+tOffset>baseline){tipY=(tipHeight>=wHeight)?sTop:baseline-tipHeight-tOffset;}else if($this.css('display')=='block'||$this[0].tagName.toLowerCase()=='area'||opts.positionBy=="mouse"){tipY=bpY-tOffset;}else{tipY=posY-opts.dropShadowSteps;}
if(direction==''){posX<linkLeft?direction='left':direction='right';}
$cluetip.css({top:tipY+'px'}).removeClass().addClass('clue-'+direction+'-'+ctClass).addClass(' cluetip-'+ctClass);if(opts.arrows){var bgY=(posY-tipY-opts.dropShadowSteps);$cluetipArrows.css({top:(/(left|right)/.test(direction)&&posX>=0&&bgY>0)?bgY+'px':/(left|right)/.test(direction)?0:''}).show();}else{$cluetipArrows.hide();}
$dropShadow.hide();$cluetip.hide()[opts.fx.open](opts.fx.open!='show'&&opts.fx.openSpeed);if(opts.dropShadow)$dropShadow.css({height:tipHeight,width:tipInnerWidth}).show();if($.fn.bgiframe){$cluetip.bgiframe();}
if(opts.delayedClose>0){closeOnDelay=setTimeout(cluetipClose,opts.delayedClose);}
opts.onShow($cluetip,$cluetipInner);};var inactivate=function(){isActive=false;$('#cluetip-waitimage').hide();if(!opts.sticky||(/click|toggle/).test(opts.activation)){cluetipClose();clearTimeout(closeOnDelay);};if(opts.hoverClass){$this.removeClass(opts.hoverClass);}
$('.cluetip-clicked').removeClass('cluetip-clicked');};var cluetipClose=function(){$cluetipOuter.parent().hide().removeClass().end().children().empty();if(tipTitle){$this.attr(opts.titleAttribute,tipTitle);}
$this.css('cursor','');if(opts.arrows)$cluetipArrows.css({top:''});};if((/click|toggle/).test(opts.activation)){$this.click(function(event){if($cluetip.is(':hidden')||!$this.is('.cluetip-clicked')){activate(event);$('.cluetip-clicked').removeClass('cluetip-clicked');$this.addClass('cluetip-clicked');}else{inactivate(event);}
this.blur();return false;});}else if(opts.activation=='focus'){$this.focus(function(event){activate(event);});$this.blur(function(event){inactivate(event);});}else{$this.click(function(){if($this.attr('href')&&$this.attr('href')==tipAttribute&&!opts.clickThrough){return false;}});var mouseTracks=function(evt){if(opts.tracking==true){var trackX=posX-evt.pageX;var trackY=tipY?tipY-evt.pageY:posY-evt.pageY;$this.mousemove(function(evt){$cluetip.css({left:evt.pageX+trackX,top:evt.pageY+trackY});});}};if($.fn.hoverIntent&&opts.hoverIntent){$this.mouseover(function(){$this.attr('title','');}).hoverIntent({sensitivity:opts.hoverIntent.sensitivity,interval:opts.hoverIntent.interval,over:function(event){activate(event);mouseTracks(event);},timeout:opts.hoverIntent.timeout,out:function(event){inactivate(event);$this.unbind('mousemove');}});}else{$this.hover(function(event){activate(event);mouseTracks(event);},function(event){inactivate(event);$this.unbind('mousemove');});}}});};$.fn.cluetip.defaults={width:275,height:'auto',cluezIndex:97,positionBy:'auto',topOffset:15,leftOffset:15,local:false,hideLocal:true,attribute:'rel',titleAttribute:'title',splitTitle:'',showTitle:true,cluetipClass:'default',hoverClass:'',waitImage:true,cursor:'help',arrows:false,dropShadow:true,dropShadowSteps:6,sticky:false,mouseOutClose:false,activation:'hover',clickThrough:false,tracking:false,delayedClose:0,closePosition:'top',closeText:'Close',truncate:0,fx:{open:'show',openSpeed:''},hoverIntent:{sensitivity:3,interval:50,timeout:0},onActivate:function(e){return true;},onShow:function(ct,c){},ajaxCache:true,ajaxProcess:function(data){data=data.replace(/<s(cript|tyle)(.|\s)*?\/s(cript|tyle)>/g,'').replace(/<(link|title)(.|\s)*?\/(link|title)>/g,'');return data;},ajaxSettings:{dataType:'html'},debug:false};var insertionType='appendTo',insertionElement='body';$.cluetip={};$.cluetip.setup=function(options){if(options&&options.insertionType&&(options.insertionType).match(/appendTo|prependTo|insertBefore|insertAfter/)){insertionType=options.insertionType;}
if(options&&options.insertionElement){insertionElement=options.insertionElement;}};})(jQuery);function GFSlider(obj){var thisObj=this;if(OGConfig.sliderOn==1){thisObj.duration=500;}else{thisObj.duration=1;}
thisObj.zIndex=10;thisObj.intervalTime=30;thisObj.lastZIndex=thisObj.zIndex;thisObj.inAction=false;thisObj.lastObj=false;thisObj.currHeight=obj.offsetHeight;thisObj.opacity=1;thisObj.header=document.getElementById('header_text');thisObj.ressButton=document.getElementById('resources_button');thisObj.areaMap=document.getElementById('transImg');this.slideIn=function(obj){if(thisObj.slideInObj){if(!thisObj.inAction){buttonId=thisObj.slideInObj.id.substr(6,10);removeClass(getElementByIdWithCache('details'+buttonId),'active');}
getElementByIdWithCache('details'+buttonId).blur();}
if(!thisObj.inAction){thisObj.slideInObj=obj;buttonId=obj.id.substr(6,10);addClass(getElementByIdWithCache('details'+buttonId),'active');getElementByIdWithCache('details'+buttonId).blur();if((obj.style.display=='none'||obj.style.zIndex!=this.lastZIndex)){thisObj.header.style.position='absolute';obj.opacity=1;if(thisObj.ressButton)thisObj.ressButton.style.display='none';if(thisObj.areaMap)thisObj.areaMap.style.display='none';obj.style.height='1px';obj.style.display='block';obj.style.overflow='hidden';obj.style.zIndex=++this.lastZIndex;thisObj.inAction=true;thisObj.startTime=new Date().getTime();thisObj.slideInStep();}else{thisObj.header.style.display='block';thisObj.opacity=0;thisObj.inAction=true;thisObj.startTime=new Date().getTime();thisObj.slideOutObj=thisObj.slideInObj;thisObj.slideOutStep();}}}
this.slideInStep=function(){obj=thisObj.slideInObj;var time=new Date().getTime();height=parseInt(thisObj.currHeight*((time-thisObj.startTime)/thisObj.duration));if(height<thisObj.currHeight){obj.style.height=(height)+'px';obj.style.marginTop=(thisObj.currHeight-1-height)+'px';window.setTimeout(thisObj.slideInStep,thisObj.intervalTime);thisObj.opacity=Math.max(thisObj.opacity-0.1,0);thisObj.header.style.opacity=thisObj.opacity;thisObj.header.style.filter='Alpha(opacity='+(0.5*100)+')';}else{obj.style.height=thisObj.currHeight+'px';obj.style.marginTop='0px';thisObj.inAction=false;thisObj.header.style.display='none';if(thisObj.lastObj&&obj!=thisObj.lastObj){thisObj.hideLast();}
thisObj.lastObj=obj;}}
this.slideOutStep=function(){obj=thisObj.slideInObj;var time=new Date().getTime();height=parseInt(thisObj.currHeight*((time-thisObj.startTime)/thisObj.duration));if(height<thisObj.currHeight){obj.style.height=(thisObj.currHeight-1-height)+'px';obj.style.marginTop=(height)+'px';window.setTimeout(thisObj.slideOutStep,thisObj.intervalTime);thisObj.opacity=Math.max(thisObj.opacity+0.1,0);thisObj.header.style.opacity=thisObj.opacity;}else{obj.style.height=thisObj.currHeight+'px';obj.style.marginTop='0px';buttonId=obj.id.substr(6,10);removeClass(getElementByIdWithCache('details'+buttonId),'active');getElementByIdWithCache('details'+buttonId).blur();thisObj.opacity=1;thisObj.header.style.opacity=thisObj.opacity;if(thisObj.ressButton){thisObj.ressButton.style.display='block';}
if(thisObj.areaMap){thisObj.areaMap.style.display='block';}
obj.style.display='none';thisObj.inAction=false;thisObj.hideLast();}}
this.hideLast=function(){if(thisObj.lastObj){thisObj.lastObj.style.display='none';thisObj.inAction=false;}},this.hide=function(obj){thisObj.slideOutObj=obj;thisObj.opacity=1;thisObj.header.style.opacity=thisObj.opacity;thisObj.header.style.display='block';if(thisObj.ressButton){thisObj.ressButton.style.display='block';}
if(thisObj.areaMap){thisObj.areaMap.style.display='block';}
thisObj.slideOutObj.style.display='none';thisObj.inAction=false;}}
function sack(file){this.AjaxFailedAlert="Your browser does not support the enhanced functionality of this website, and therefore you will have an experience that differs from the intended one.\n";this.requestFile=file;this.method="POST";this.URLString="";this.encodeURIString=true;this.execute=false;this.onLoading=function(){};this.onLoaded=function(){};this.onInteractive=function(){};this.onCompletion=function(){};this.createAJAX=function(){try{this.xmlhttp=new ActiveXObject("Msxml2.XMLHTTP");}catch(e){try{this.xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}catch(err){this.xmlhttp=null;}}
if(!this.xmlhttp&&typeof XMLHttpRequest!="undefined")
this.xmlhttp=new XMLHttpRequest();if(!this.xmlhttp){this.failed=true;}};this.setVar=function(name,value){if(this.URLString.length<3){this.URLString=name+"="+value;}else{this.URLString+="&"+name+"="+value;}}
this.encVar=function(name,value){var varString=encodeURIComponent(name)+"="+encodeURIComponent(value);return varString;}
this.encodeURLString=function(string){varArray=string.split('&');for(i=0;i<varArray.length;i++){urlVars=varArray[i].split('=');if(urlVars[0].indexOf('amp;')!=-1){urlVars[0]=urlVars[0].substring(4);}
varArray[i]=this.encVar(urlVars[0],urlVars[1]);}
return varArray.join('&');}
this.runResponse=function(){eval(this.response);}
this.runAJAX=function(urlstring){this.responseStatus=new Array(2);if(this.failed&&this.AjaxFailedAlert){alert(this.AjaxFailedAlert);}else{if(urlstring){if(this.URLString.length){this.URLString=this.URLString+"&"+urlstring;}else{this.URLString=urlstring;}}
if(this.encodeURIString){var timeval=new Date().getTime();this.URLString=this.encodeURLString(this.URLString);this.setVar("rndval",timeval);}
if(this.element){this.elementObj=document.getElementById(this.element);}
if(this.xmlhttp){var self=this;if(this.method=="GET"){var totalurlstring=this.requestFile+"?"+this.URLString;this.xmlhttp.open(this.method,totalurlstring,true);}else{this.xmlhttp.open(this.method,this.requestFile,true);}
if(this.method=="POST"){try{this.xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded')}catch(e){}}
this.xmlhttp.send(this.URLString);this.xmlhttp.onreadystatechange=function(){switch(self.xmlhttp.readyState){case 1:self.onLoading();break;case 2:self.onLoaded();break;case 3:self.onInteractive();break;case 4:self.response=self.xmlhttp.responseText;self.responseXML=self.xmlhttp.responseXML;self.responseStatus[0]=self.xmlhttp.status;self.responseStatus[1]=self.xmlhttp.statusText;self.onCompletion();if(self.execute){self.runResponse();}
if(self.elementObj){var elemNodeName=self.elementObj.nodeName;elemNodeName.toLowerCase();if(elemNodeName=="input"||elemNodeName=="select"||elemNodeName=="option"||elemNodeName=="textarea"){self.elementObj.value=self.response;}else{self.elementObj.innerHTML=self.response;}}
self.URLString="";break;}};}}};this.createAJAX();}
function getDistance()
{var diffGalaxy;var diffSystem;var diffPlanet;diffGalaxy=Math.abs(currentGalaxy-targetGalaxy);diffSystem=Math.abs(currentSystem-targetSystem);diffPlanet=Math.abs(currentPosition-targetPosition);if(diffGalaxy!=0)
{return diffGalaxy*20000;}
else if(diffSystem!=0)
{return diffSystem*5*19+2700;}
else if(diffPlanet!=0)
{return diffPlanet*5+1000;}
else
{return 5;}}
function getDuration()
{return Math.round(((35000/speed*Math.sqrt(distance*10/maxSpeed)+10)/speedFactor));}
function getConsumption(onlyID)
{var consumptionCounter=0;var holdingConsumption=0;var countedShips=0;for(i=0,maxI=shipIDs.length;i<maxI;i++)
{if(onlyID==0||onlyID==null||shipIDs[i]==onlyID)
{countedShips++;shipSpeedValue=35000/(duration*speedFactor-10)*Math.sqrt(distance*10/speeds[i]);holdingConsumption+=completeConsumptions[i]*holdingTime;consumptionCounter+=completeConsumptions[i]*distance/35000*((shipSpeedValue/10)+1)*((shipSpeedValue/10)+1);}}
if(countedShips>0)
{consumptionCounter=Math.round(consumptionCounter)+1;if(holdingTime>0)
{consumptionCounter+=Math.max(Math.floor(holdingConsumption/10),1);}
return consumptionCounter;}
else
{return 0}}
function getFreeStorage()
{var freeStorageCounter=storageCapacity;freeStorageCounter-=consumption;freeStorageCounter-=(probeStorageCapacity-getConsumption(210));return freeStorageCounter;}
function updateVariables()
{if(typeof prepareVariables=="function")
{prepareVariables();}
distance=getDistance();duration=getDuration();consumption=getConsumption();cargoSpace=getFreeStorage();cargoLeft=cargoSpace-metal-crystal-deuterium;if(typeof refreshFormData=="function")
{refreshFormData();}}
var DOM_GET_ELEMENT_BY_ID_CACHE=new Array();function getElementByIdWithCache(uid){if(!DOM_GET_ELEMENT_BY_ID_CACHE[uid]){DOM_GET_ELEMENT_BY_ID_CACHE[uid]=document.getElementById(uid);}
return DOM_GET_ELEMENT_BY_ID_CACHE[uid];}
function addListener(obj,type,fn)
{if(obj.addEventListener){if(type=='mousewheel'){type='DOMMouseScroll';}
obj.addEventListener(type,fn,false);}else if(obj.attachEvent){obj["e"+type+fn]=fn;obj[type+fn]=function(){obj["e"+type+fn](window.event);};obj.attachEvent('on'+type,obj[type+fn]);}}
function removeListener(obj,type,fn){if(obj.removeEventListener){obj.removeEventListener(type,fn,false);}else if(obj.detachEvent){obj.detachEvent("on"+type,obj[type+fn]);obj[type+fn]=null;obj["e"+type+fn]=null;}}
function addClass(obj,cName){if(obj&&cName&&cName!='undefined'){removeClass(obj,cName);obj.className+=' '+cName;}}
function removeClass(obj,cName){if(obj&&obj.className){obj.className=obj.className.replace(cName,'');}}
function getAllChildNodesWithClassName(obj,childNodesWithClassName){if(!childNodesWithClassName){var childNodesWithClassName=new Array();}
var i=0;if(obj.childNodes){for(i in obj.childNodes){if(obj.childNodes[i].className){childNodesWithClassName.push(obj.childNodes[i]);}
if(obj.childNodes[i].firstChild){childNodesWithClassName.concat(getAllChildNodesWithClassName(obj.childNodes[i],childNodesWithClassName));}}}
return childNodesWithClassName;}
function hasClassName(obj,needle){if(obj.className&&needle){var haystack=obj.className;return(haystack==needle||haystack.indexOf(" "+needle+" ")>=0||haystack.indexOf(needle+" ")==0||(haystack.indexOf(" "+needle)>0&&haystack.indexOf(" "+needle)==haystack.length-((" "+needle).length)));}else{return false;}}
function getChildNodesWithClassName(obj,className,childNodesWithClassName){if(!childNodesWithClassName){var childNodesWithClassName=new Array();}
var i=0;if(obj.childNodes){for(i in obj.childNodes){if(obj.childNodes[i]&&obj.childNodes[i].className&&hasClassName(obj.childNodes[i],className)){childNodesWithClassName.push(obj.childNodes[i]);}
if(obj.childNodes[i]&&obj.childNodes[i].firstChild){childNodesWithClassName.concat(getChildNodesWithClassName(obj.childNodes[i],className,childNodesWithClassName));}}}
return childNodesWithClassName;}
function getChildNodeWithClassName(obj,className){if(obj.childNodes){for(i in obj.childNodes){if(hasClassName(obj.childNodes[i],className)){return obj.childNodes[i];}else if(obj.childNodes[i].firstChild){var node=getChildNodeWithClassName(obj.childNodes[i],className);if(node){return node;}}}}
return false;}
function getChildNodesWithTagName(obj,tagName,childNodesWithTagName){if(!childNodesWithTagName){var childNodesWithTagName=new Array();}
var i=0;if(obj.childNodes){for(i in obj.childNodes){if(obj.childNodes[i].tagName&&obj.childNodes[i].tagName==tagName.toUpperCase()){childNodesWithTagName.push(obj.childNodes[i]);}
if(obj.childNodes[i].firstChild){childNodesWithTagName.concat(getChildNodesWithTagName(obj.childNodes[i],tagName,childNodesWithTagName));}}}
return childNodesWithTagName;}
function splitParameterStringToArray(str){var arr=new Object();var vars=str.split(" ");for(var i in vars){var pair=vars[i].split("=");if(pair[0]){arr[pair[0]]=pair[1];}}
return arr;}
function number_format(number,decimals,dec_point,thousands_sep)
{dec_point=LocalizationStrings['decimalPoint'];thousands_sep=LocalizationStrings['thousandSeperator'];var exponent="";var numberstr=number.toString();var eindex=numberstr.indexOf("e");if(eindex>-1)
{exponent=numberstr.substring(eindex);number=parseFloat(numberstr.substring(0,eindex));}
if(decimals!=null)
{var temp=Math.pow(10,decimals);number=Math.round(number*temp)/temp;}
var sign=number<0?"-":"";var integer=(number>0?Math.floor(number):Math.abs(Math.ceil(number))).toString();var fractional=number.toString().substring(integer.length+sign.length);dec_point=dec_point!=null?dec_point:".";fractional=decimals!=null&&decimals>0||fractional.length>1?(dec_point+fractional.substring(1)):"";if(decimals!=null&&decimals>0)
{for(i=fractional.length-1,z=decimals;i<z;++i)
fractional+="0";}
thousands_sep=(thousands_sep!=dec_point||fractional.length==0)?thousands_sep:null;if(thousands_sep!=null&&thousands_sep!="")
{for(i=integer.length-3;i>0;i-=3)
integer=integer.substring(0,i)+thousands_sep+integer.substring(i);}
return sign+integer+fractional+exponent;}
function gfNumberGetHumanReadable(value)
{value=Math.floor(value);var unit='';var precision=3;if(value>=1000000000){unit=LocalizationStrings['unitMilliard'];value=value/1000000000;}
if(value>=1000000){unit=LocalizationStrings['unitMega'];value=value/1000000;}
floorWithPrecision=function(value,precision){return Math.floor(value*Math.pow(10,precision))/Math.pow(10,precision);}
value=floorWithPrecision(value,precision);while(precision>=0){if(floorWithPrecision(value,precision-1)!=value){break;}
precision=precision-1;}
return number_format(value,precision,LocalizationStrings['decimalPoint'],LocalizationStrings['thousandSeperator'])+unit;}
function dezInt(num,size,prefix){prefix=(prefix)?prefix:"0";var minus=(num<0)?"-":"",result=(prefix=="0")?minus:"";num=Math.abs(parseInt(num,10));size-=(""+num).length;for(var i=1;i<=size;i++){result+=""+prefix;}
result+=((prefix!="0")?minus:"")+num;return result;}
function ajaxSendUrl(aUrl){var xmlHttp=null;if(typeof XMLHttpRequest!='undefined'){xmlHttp=new XMLHttpRequest();}
if(!xmlHttp){try{xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");}catch(e){try{xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");}catch(e){xmlHttp=null;}}}
if(xmlHttp){xmlHttp.open('POST',aUrl,true);xmlHttp.onreadystatechange=function(){if(xmlHttp.readyState==4){}};xmlHttp.send(null);}}
function ajaxRequest(aUrl,aFunction){var xmlHttp=null;if(typeof XMLHttpRequest!='undefined'){xmlHttp=new XMLHttpRequest();}
if(!xmlHttp){try{xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");}catch(e){try{xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");}catch(e){xmlHttp=null;}}}
if(xmlHttp){xmlHttp.open('POST',aUrl,true);xmlHttp.onreadystatechange=function(){if(xmlHttp.readyState==4){var tmp=new aFunction(xmlHttp.responseText);}};xmlHttp.send(null);}}
function MessageSlider(obj){var thisObj=this;thisObj.htmlobject=obj;var maxHeight=document.documentElement.clientHeight-160;this.open=function(){if(!this.inAction){thisObj.startTime=new Date().getTime();thisObj.inAction=true;thisObj.slideInStep();}},this.slideInStep=function(){time=new Date().getTime();height=parseInt(thisObj.currHeight*((time-thisObj.startTime)/500));if(height<thisObj.currHeight){thisObj.htmlobject.style.height=height+'px';window.setTimeout(thisObj.slideInStep,10);}else{thisObj.htmlobject.style.height=thisObj.currHeight+'px';thisObj.inAction=false;}},this.close=function(){if(!thisObj.inAction){thisObj.startTime=new Date().getTime();thisObj.inAction=true;thisObj.htmlobject.style.height="0px";thisObj.inAction=false;}},thisObj.inAction=false;if(document.getElementById('messages')){thisObj.currHeight=Math.min(document.getElementById('messages').offsetHeight,maxHeight);}else{thisObj.currHeight=maxHeight;}}
(function($){var height=$.fn.height,width=$.fn.width;$.fn.extend({height:function(){if(!this[0])error();if(this[0]==window)
if($.browser.opera||($.browser.safari&&parseInt($.browser.version)>520))
return self.innerHeight-(($(document).height()>self.innerHeight)?getScrollbarWidth():0);else if($.browser.safari)
return self.innerHeight;else
return $.boxModel&&document.documentElement.clientHeight||document.body.clientHeight;if(this[0]==document)
return Math.max(($.boxModel&&document.documentElement.scrollHeight||document.body.scrollHeight),document.body.offsetHeight);return height.apply(this,arguments);},width:function(){if(!this[0])error();if(this[0]==window)
if($.browser.opera||($.browser.safari&&parseInt($.browser.version)>520))
return self.innerWidth-(($(document).width()>self.innerWidth)?getScrollbarWidth():0);else if($.browser.safari)
return self.innerWidth;else
return $.boxModel&&document.documentElement.clientWidth||document.body.clientWidth;if(this[0]==document)
if($.browser.mozilla){var scrollLeft=self.pageXOffset;self.scrollTo(99999999,self.pageYOffset);var scrollWidth=self.pageXOffset;self.scrollTo(scrollLeft,self.pageYOffset);return document.body.offsetWidth+scrollWidth;}
else
return Math.max((($.boxModel&&!$.browser.safari)&&document.documentElement.scrollWidth||document.body.scrollWidth),document.body.offsetWidth);return width.apply(this,arguments);},innerHeight:function(){if(!this[0])error();return this[0]==window||this[0]==document?this.height():this.is(':visible')?this[0].offsetHeight-num(this,'borderTopWidth')-num(this,'borderBottomWidth'):this.height()+num(this,'paddingTop')+num(this,'paddingBottom');},innerWidth:function(){if(!this[0])error();return this[0]==window||this[0]==document?this.width():this.is(':visible')?this[0].offsetWidth-num(this,'borderLeftWidth')-num(this,'borderRightWidth'):this.width()+num(this,'paddingLeft')+num(this,'paddingRight');},outerHeight:function(options){if(!this[0])error();options=$.extend({margin:false},options||{});return this[0]==window||this[0]==document?this.height():this.is(':visible')?this[0].offsetHeight+(options.margin?(num(this,'marginTop')+num(this,'marginBottom')):0):this.height()
+num(this,'borderTopWidth')+num(this,'borderBottomWidth')
+num(this,'paddingTop')+num(this,'paddingBottom')
+(options.margin?(num(this,'marginTop')+num(this,'marginBottom')):0);},outerWidth:function(options){if(!this[0])error();options=$.extend({margin:false},options||{});return this[0]==window||this[0]==document?this.width():this.is(':visible')?this[0].offsetWidth+(options.margin?(num(this,'marginLeft')+num(this,'marginRight')):0):this.width()
+num(this,'borderLeftWidth')+num(this,'borderRightWidth')
+num(this,'paddingLeft')+num(this,'paddingRight')
+(options.margin?(num(this,'marginLeft')+num(this,'marginRight')):0);},scrollLeft:function(val){if(!this[0])error();if(val!=undefined)
return this.each(function(){if(this==window||this==document)
window.scrollTo(val,$(window).scrollTop());else
this.scrollLeft=val;});if(this[0]==window||this[0]==document)
return self.pageXOffset||$.boxModel&&document.documentElement.scrollLeft||document.body.scrollLeft;return this[0].scrollLeft;},scrollTop:function(val){if(!this[0])error();if(val!=undefined)
return this.each(function(){if(this==window||this==document)
window.scrollTo($(window).scrollLeft(),val);else
this.scrollTop=val;});if(this[0]==window||this[0]==document)
return self.pageYOffset||$.boxModel&&document.documentElement.scrollTop||document.body.scrollTop;return this[0].scrollTop;},position:function(returnObject){return this.offset({margin:false,scroll:false,relativeTo:this.offsetParent()},returnObject);},offset:function(options,returnObject){if(!this[0])error();var x=0,y=0,sl=0,st=0,elem=this[0],parent=this[0],op,parPos,elemPos=$.css(elem,'position'),mo=$.browser.mozilla,ie=$.browser.msie,oa=$.browser.opera,sf=$.browser.safari,sf3=$.browser.safari&&parseInt($.browser.version)>520,absparent=false,relparent=false,options=$.extend({margin:true,border:false,padding:false,scroll:true,lite:false,relativeTo:document.body},options||{});if(options.lite)return this.offsetLite(options,returnObject);if(options.relativeTo.jquery)options.relativeTo=options.relativeTo[0];if(elem.tagName=='BODY'){x=elem.offsetLeft;y=elem.offsetTop;if(mo){x+=num(elem,'marginLeft')+(num(elem,'borderLeftWidth')*2);y+=num(elem,'marginTop')+(num(elem,'borderTopWidth')*2);}else
if(oa){x+=num(elem,'marginLeft');y+=num(elem,'marginTop');}else
if((ie&&jQuery.boxModel)){x+=num(elem,'borderLeftWidth');y+=num(elem,'borderTopWidth');}else
if(sf3){x+=num(elem,'marginLeft')+num(elem,'borderLeftWidth');y+=num(elem,'marginTop')+num(elem,'borderTopWidth');}}else{do{parPos=$.css(parent,'position');x+=parent.offsetLeft;y+=parent.offsetTop;if((mo&&!parent.tagName.match(/^t[d|h]$/i))||ie||sf3){x+=num(parent,'borderLeftWidth');y+=num(parent,'borderTopWidth');if(mo&&parPos=='absolute')absparent=true;if(ie&&parPos=='relative')relparent=true;}
op=parent.offsetParent||document.body;if(options.scroll||mo){do{if(options.scroll){sl+=parent.scrollLeft;st+=parent.scrollTop;}
if(oa&&($.css(parent,'display')||'').match(/table-row|inline/)){sl=sl-((parent.scrollLeft==parent.offsetLeft)?parent.scrollLeft:0);st=st-((parent.scrollTop==parent.offsetTop)?parent.scrollTop:0);}
if(mo&&parent!=elem&&$.css(parent,'overflow')!='visible'){x+=num(parent,'borderLeftWidth');y+=num(parent,'borderTopWidth');}
parent=parent.parentNode;}while(parent!=op);}
parent=op;if(parent==options.relativeTo&&!(parent.tagName=='BODY'||parent.tagName=='HTML')){if(mo&&parent!=elem&&$.css(parent,'overflow')!='visible'){x+=num(parent,'borderLeftWidth');y+=num(parent,'borderTopWidth');}
if(((sf&&!sf3)||oa)&&parPos!='static'){x-=num(op,'borderLeftWidth');y-=num(op,'borderTopWidth');}
break;}
if(parent.tagName=='BODY'||parent.tagName=='HTML'){if(((sf&&!sf3)||(ie&&$.boxModel))&&elemPos!='absolute'&&elemPos!='fixed'){x+=num(parent,'marginLeft');y+=num(parent,'marginTop');}
if(sf3||(mo&&!absparent&&elemPos!='fixed')||(ie&&elemPos=='static'&&!relparent)){x+=num(parent,'borderLeftWidth');y+=num(parent,'borderTopWidth');}
break;}}while(parent);}
var returnValue=handleOffsetReturn(elem,options,x,y,sl,st);if(returnObject){$.extend(returnObject,returnValue);return this;}
else{return returnValue;}},offsetLite:function(options,returnObject){if(!this[0])error();var x=0,y=0,sl=0,st=0,parent=this[0],offsetParent,options=$.extend({margin:true,border:false,padding:false,scroll:true,relativeTo:document.body},options||{});if(options.relativeTo.jquery)options.relativeTo=options.relativeTo[0];do{x+=parent.offsetLeft;y+=parent.offsetTop;offsetParent=parent.offsetParent||document.body;if(options.scroll){do{sl+=parent.scrollLeft;st+=parent.scrollTop;parent=parent.parentNode;}while(parent!=offsetParent);}
parent=offsetParent;}while(parent&&parent.tagName!='BODY'&&parent.tagName!='HTML'&&parent!=options.relativeTo);var returnValue=handleOffsetReturn(this[0],options,x,y,sl,st);if(returnObject){$.extend(returnObject,returnValue);return this;}
else{return returnValue;}},offsetParent:function(){if(!this[0])error();var offsetParent=this[0].offsetParent;while(offsetParent&&(offsetParent.tagName!='BODY'&&$.css(offsetParent,'position')=='static'))
offsetParent=offsetParent.offsetParent;return $(offsetParent);}});var error=function(){throw"Dimensions: jQuery collection is empty";};var num=function(el,prop){return parseInt($.css(el.jquery?el[0]:el,prop))||0;};var handleOffsetReturn=function(elem,options,x,y,sl,st){if(!options.margin){x-=num(elem,'marginLeft');y-=num(elem,'marginTop');}
if(options.border&&(($.browser.safari&&parseInt($.browser.version)<520)||$.browser.opera)){x+=num(elem,'borderLeftWidth');y+=num(elem,'borderTopWidth');}else if(!options.border&&!(($.browser.safari&&parseInt($.browser.version)<520)||$.browser.opera)){x-=num(elem,'borderLeftWidth');y-=num(elem,'borderTopWidth');}
if(options.padding){x+=num(elem,'paddingLeft');y+=num(elem,'paddingTop');}
if(options.scroll&&(!$.browser.opera||elem.offsetLeft!=elem.scrollLeft&&elem.offsetTop!=elem.scrollLeft)){sl-=elem.scrollLeft;st-=elem.scrollTop;}
return options.scroll?{top:y-st,left:x-sl,scrollTop:st,scrollLeft:sl}:{top:y,left:x};};var scrollbarWidth=0;var getScrollbarWidth=function(){if(!scrollbarWidth){var testEl=$('<div>').css({width:100,height:100,overflow:'auto',position:'absolute',top:-1000,left:-1000}).appendTo('body');scrollbarWidth=100-testEl.append('<div>').find('div').css({width:'100%',height:200}).width();testEl.remove();}
return scrollbarWidth;};})(jQuery);eval(function(p,a,c,k,e,d){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--){d[e(c)]=k[c]||e(c)}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('(4(D){b C=D.2o.11;D.2o.11=4(){D("*",2).1d(2).2F("11");7 C.1G(2,2Q)};4 B(E){4 G(H){b I=H.2g;7(I.1q!="1Y"&&I.3Y!="2s")}b F=G(E);(F&&D.z(D.3X(E,"3i"),4(){7(F=G(2))}));7 F}D.1u(D.3W[":"],{i:4(F,G,E){7 D.i(F,E[3])},3U:4(F,G,E){b H=F.3V.3Z();7(F.41>=0&&(("a"==H&&F.t)||(/48|1m|47|3o/.1a(H)&&"2s"!=F.2D&&!F.h))&&B(F))}});D.44={42:8,43:20,3T:3S,3J:17,3K:46,3I:40,3H:35,3F:13,3G:27,3L:36,3M:45,3R:37,3Q:3P,3N:3O,49:4a,4t:4s,4r:4p,4q:4u,4v:34,4A:33,3E:4y,4w:39,4x:16,4o:32,4n:9,4f:38};4 A(H,I,J,G){4 F(L){b K=D[H][I][L]||[];7(1r K=="1i"?K.2j(/,?\\s+/):K)}b E=F("30");6(G.l==1&&1r G[0]=="1i"){E=E.2C(F("2L"))}7(D.1v(J,E)!=-1)}D.1p=4(F,E){b G=F.2j(".")[0];F=F.2j(".")[1];D.2o[F]=4(K){b I=(1r K=="1i"),J=2P.1k.4e.2H(2Q,1);6(I&&K.4d(0,1)=="2k"){7 2}6(I&&A(G,F,K,J)){b H=D.i(2[0],F);7(H?H[K].1G(H,J):1n)}7 2.z(4(){b L=D.i(2,F);(!L&&!I&&D.i(2,F,4b D[G][F](2,K)));(L&&I&&D.4c(L[K])&&L[K].1G(L,J))})};D[G][F]=4(J,I){b H=2;2.1c=F;2.1X=D[G][F].4g||F;2.2E=G+"-"+F;2.d=D.1u({},D.1p.1z,D[G][F].1z,D.2R&&D.2R.1T(J)[F],I);2.k=D(J).w("4h."+F,4(M,K,L){7 H.1o(K,L)}).w("4m."+F,4(L,K){7 H.1U(K)}).w("11",4(){7 H.1g()});2.1W()};D[G][F].1k=D.1u({},D.1p.1k,E);D[G][F].2L="2K"};D.1p.1k={1W:4(){},1g:4(){2.k.1y(2.1c)},2K:4(G,H){b F=G,E=2;6(1r G=="1i"){6(H===1n){7 2.1U(G)}F={};F[G]=H}D.z(F,4(I,J){E.1o(I,J)})},1U:4(E){7 2.d[E]},1o:4(E,F){2.d[E]=F;6(E=="h"){2.k[F?"n":"u"](2.2E+"-h")}},2a:4(){2.1o("h",f)},1Z:4(){2.1o("h",y)},14:4(F,H,G){b E=(F==2.1X?F:2.1X+F);H=H||D.18.4l({2D:E,2m:2.k[0]});7 2.k.2F(E,[H,G],2.d[F])}};D.1p.1z={h:f};D.c={4k:{1d:4(F,G,I){b H=D.c[F].1k;28(b E 4i I){H.1I[E]=H.1I[E]||[];H.1I[E].29([G,I[E]])}},2H:4(E,G,F){b I=E.1I[G];6(!I){7}28(b H=0;H<I.l;H++){6(E.d[I[H][0]]){I[H][1].1G(E.k,F)}}}},1C:{},q:4(E){6(D.c.1C[E]){7 D.c.1C[E]}b F=D(\'<23 4j="c-4B">\').n(E).q({3w:"3t",3u:"-2I",3b:"-2I",1q:"1D"}).2p("3c");D.c.1C[E]=!!((!(/3z|3C/).1a(F.q("3y"))||(/^[1-9]/).1a(F.q("2O"))||(/^[1-9]/).1a(F.q("2J"))||!(/1Y/).1a(F.q("3x"))||!(/3A|3v\\(0, 0, 0, 0\\)/).1a(F.q("3B"))));3D{D("3c").1T(0).3r(F.1T(0))}3s(G){}7 D.c.1C[E]},4z:4(E){7 D(E).x("1s","3d").q("3a","1Y").w("31.c",4(){7 f})},4D:4(E){7 D(E).x("1s","5r").q("3a","").12("31.c")},5z:4(H,F){6(D(H).q("2B")=="2s"){7 f}b E=(F&&F=="3b")?"5q":"59",G=f;6(H[E]>0){7 y}H[E]=1;G=(H[E]>0);H[E]=0;7 G}};D.c.2A={5g:4(){b E=2;2.k.w("5h."+2.1c,4(F){7 E.3f(F)});6(D.U.1e){2.2U=2.k.x("1s");2.k.x("1s","3d")}2.5n=f},5l:4(){2.k.12("."+2.1c);(D.U.1e&&2.k.x("1s",2.2U))},3f:4(G){(2.Z&&2.1A(G));2.1H=G;b F=2,H=(G.5j==1),E=(1r 2.d.2b=="1i"?D(G.2m).2M().1d(G.2m).V(2.d.2b).l:f);6(!H||E||!2.2Y(G)){7 y}2.1Q=!2.d.24;6(!2.1Q){2.5k=1K(4(){F.1Q=y},2.d.24)}6(2.2n(G)&&2.2c(G)){2.Z=(2.2v(G)!==f);6(!2.Z){G.5i();7 y}}2.2y=4(I){7 F.3e(I)};2.2r=4(I){7 F.1A(I)};D(3q).w("2S."+2.1c,2.2y).w("3p."+2.1c,2.2r);7 f},3e:4(E){6(D.U.1e&&!E.3o){7 2.1A(E)}6(2.Z){2.21(E);7 f}6(2.2n(E)&&2.2c(E)){2.Z=(2.2v(2.1H,E)!==f);(2.Z?2.21(E):2.1A(E))}7!2.Z},1A:4(E){D(3q).12("2S."+2.1c,2.2y).12("3p."+2.1c,2.2r);6(2.Z){2.Z=f;2.3n(E)}7 f},2n:4(E){7(1V.5m(1V.3g(2.1H.3h-E.3h),1V.3g(2.1H.3m-E.3m))>=2.d.2z)},2c:4(E){7 2.1Q},2v:4(E){},21:4(E){},3n:4(E){},2Y:4(E){7 y}};D.c.2A.1z={2b:p,2z:1,24:0}})(2l);(4(A){A.1p("c.5",{1W:4(){2.d.18+=".5";2.1w(y)},1o:4(B,C){6((/^e/).1a(B)){2.1m(C)}r{2.d[B]=C;2.1w()}},l:4(){7 2.$5.l},2q:4(B){7 B.2G&&B.2G.1l(/\\s/g,"2k").1l(/[^A-5b-5a-9\\-2k:\\.]/g,"")||2.d.2W+A.i(B)},c:4(C,B){7{d:2.d,5c:C,2Z:B,Y:2.$5.Y(C)}},1w:4(O){2.$m=A("1O:5d(a[t])",2.k);2.$5=2.$m.1E(4(){7 A("a",2)[0]});2.$j=A([]);b P=2,D=2.d;2.$5.z(4(R,Q){6(Q.15&&Q.15.1l("#","")){P.$j=P.$j.1d(Q.15)}r{6(A(Q).x("t")!="#"){A.i(Q,"t.5",Q.t);A.i(Q,"v.5",Q.t);b T=P.2q(Q);Q.t="#"+T;b S=A("#"+T);6(!S.l){S=A(D.22).x("1t",T).n(D.1x).5f(P.$j[R-1]||P.k);S.i("1g.5",y)}P.$j=P.$j.1d(S)}r{D.h.29(R+1)}}});6(O){2.k.n(D.25);2.$j.z(4(){b Q=A(2);Q.n(D.1x)});6(D.e===1n){6(2x.15){2.$5.z(4(S,Q){6(Q.15==2x.15){D.e=S;6(A.U.1e||A.U.5e){b R=A(2x.15),T=R.x("1t");R.x("1t","");1K(4(){R.x("1t",T)},5p)}5y(0,0);7 f}})}r{6(D.X){b J=5w(A.X("c-5-"+A.i(P.k[0])),10);6(J&&P.$5[J]){D.e=J}}r{6(P.$m.V("."+D.o).l){D.e=P.$m.Y(P.$m.V("."+D.o)[0])}}}}D.e=D.e===p||D.e!==1n?D.e:0;D.h=A.4C(D.h.2C(A.1E(2.$m.V("."+D.1f),4(R,Q){7 P.$m.Y(R)}))).3l();6(A.1v(D.e,D.h)!=-1){D.h.5A(A.1v(D.e,D.h),1)}2.$j.n(D.19);2.$m.u(D.o);6(D.e!==p){2.$j.W(D.e).2w().u(D.19);2.$m.W(D.e).n(D.o);b K=4(){P.14("2w",p,P.c(P.$5[D.e],P.$j[D.e]))};6(A.i(2.$5[D.e],"v.5")){2.v(D.e,K)}r{K()}}A(5t).w("5v",4(){P.$5.12(".5");P.$m=P.$5=P.$j=p})}r{D.e=2.$m.Y(2.$m.V("."+D.o)[0])}6(D.X){A.X("c-5-"+A.i(P.k[0]),D.e,D.X)}28(b G=0,N;N=2.$m[G];G++){A(N)[A.1v(G,D.h)!=-1&&!A(N).1j(D.o)?"n":"u"](D.1f)}6(D.1b===f){2.$5.1y("1b.5")}b C,I,B={"5x-2J":0,2i:1},E="5s";6(D.1h&&D.1h.5u==2P){C=D.1h[0]||B,I=D.1h[1]||B}r{C=I=D.1h||B}b H={1q:"",2B:"",2O:""};6(!A.U.1e){H.2e=""}4 M(R,Q,S){Q.2N(C,C.2i||E,4(){Q.n(D.19).q(H);6(A.U.1e&&C.2e){Q[0].2g.V=""}6(S){L(R,S,Q)}})}4 L(R,S,Q){6(I===B){S.q("1q","1D")}S.2N(I,I.2i||E,4(){S.u(D.19).q(H);6(A.U.1e&&I.2e){S[0].2g.V=""}P.14("2w",p,P.c(R,S[0]))})}4 F(R,T,Q,S){T.n(D.o).5o().u(D.o);M(R,Q,S)}2.$5.12(".5").w(D.18,4(){b T=A(2).2M("1O:W(0)"),Q=P.$j.V(":57"),S=A(2.15);6((T.1j(D.o)&&!D.1R)||T.1j(D.1f)||A(2).1j(D.1B)||P.14("1m",p,P.c(2,S[0]))===f){2.1N();7 f}P.d.e=P.$5.Y(2);6(D.1R){6(T.1j(D.o)){P.d.e=p;T.u(D.o);P.$j.1S();M(2,Q);2.1N();7 f}r{6(!Q.l){P.$j.1S();b R=2;P.v(P.$5.Y(2),4(){T.n(D.o).n(D.26);L(R,S)});2.1N();7 f}}}6(D.X){A.X("c-5-"+A.i(P.k[0]),P.d.e,D.X)}P.$j.1S();6(S.l){b R=2;P.v(P.$5.Y(2),Q.l?4(){F(R,T,Q,S)}:4(){T.n(D.o);L(R,S)})}r{4M"2l 4L 4N: 4O 4Q 4P."}6(A.U.1e){2.1N()}7 f});6(!(/^2f/).1a(D.18)){2.$5.w("2f.5",4(){7 f})}},1d:4(E,D,C){6(C==1n){C=2.$5.l}b G=2.d;b I=A(G.2V.1l(/#\\{t\\}/g,E).1l(/#\\{1L\\}/g,D));I.i("1g.5",y);b H=E.4K("#")==0?E.1l("#",""):2.2q(A("a:4J-4E",I)[0]);b F=A("#"+H);6(!F.l){F=A(G.22).x("1t",H).n(G.19).i("1g.5",y)}F.n(G.1x);6(C>=2.$m.l){I.2p(2.k);F.2p(2.k[0].3i)}r{I.3j(2.$m[C]);F.3j(2.$j[C])}G.h=A.1E(G.h,4(K,J){7 K>=C?++K:K});2.1w();6(2.$5.l==1){I.n(G.o);F.u(G.19);b B=A.i(2.$5[0],"v.5");6(B){2.v(C,B)}}2.14("1d",p,2.c(2.$5[C],2.$j[C]))},11:4(B){b D=2.d,E=2.$m.W(B).11(),C=2.$j.W(B).11();6(E.1j(D.o)&&2.$5.l>1){2.1m(B+(B+1<2.$5.l?1:-1))}D.h=A.1E(A.3k(D.h,4(G,F){7 G!=B}),4(G,F){7 G>=B?--G:G});2.1w();2.14("11",p,2.c(E.2t("a")[0],C[0]))},2a:4(B){b C=2.d;6(A.1v(B,C.h)==-1){7}b D=2.$m.W(B).u(C.1f);6(A.U.58){D.q("1q","4F-1D");1K(4(){D.q("1q","1D")},0)}C.h=A.3k(C.h,4(F,E){7 F!=B});2.14("2a",p,2.c(2.$5[B],2.$j[B]))},1Z:4(C){b B=2,D=2.d;6(C!=D.e){2.$m.W(C).n(D.1f);D.h.29(C);D.h.3l();2.14("1Z",p,2.c(2.$5[C],2.$j[C]))}},1m:4(B){6(1r B=="1i"){B=2.$5.Y(2.$5.V("[t$="+B+"]")[0])}2.$5.W(B).4G(2.d.18)},v:4(G,K){b L=2,D=2.d,E=2.$5.W(G),J=E[0],H=K==1n||K===f,B=E.i("v.5");K=K||4(){};6(!B||!H&&A.i(J,"1b.5")){K();7}b M=4(N){b O=A(N),P=O.2t("*:4I");7 P.l&&P.4H(":4R(4S)")&&P||O};b C=4(){L.$5.V("."+D.1B).u(D.1B).z(4(){6(D.1P){M(2).52().1F(M(2).i("1L.5"))}});L.1J=p};6(D.1P){b I=M(J).1F();M(J).51("<2u></2u>").2t("2u").i("1L.5",I).1F(D.1P)}b F=A.1u({},D.1M,{2X:B,2h:4(O,N){A(J.15).1F(O);C();6(D.1b){A.i(J,"1b.5",y)}L.14("v",p,L.c(L.$5[G],L.$j[G]));D.1M.2h&&D.1M.2h(O,N);K()}});6(2.1J){2.1J.53();C()}E.n(D.1B);1K(4(){L.1J=A.54(F)},0)},2X:4(C,B){2.$5.W(C).1y("1b.5").i("v.5",B)},1g:4(){b B=2.d;2.k.12(".5").u(B.25).1y("5");2.$5.z(4(){b C=A.i(2,"t.5");6(C){2.t=C}b D=A(2).12(".5");A.z(["t","v","1b"],4(E,F){D.1y(F+".5")})});2.$m.1d(2.$j).z(4(){6(A.i(2,"1g.5")){A(2).11()}r{A(2).u([B.o,B.26,B.1f,B.1x,B.19].56(" "))}})}});A.c.5.1z={1R:f,18:"2f",h:[],X:p,1P:"55&#50;",1b:f,2W:"c-5-",1M:{},1h:p,2V:\'<1O><a t="#{t}"><2T>#{1L}</2T></a></1O>\',22:"<23></23>",25:"c-5-4Z",o:"c-5-e",26:"c-5-1R",1f:"c-5-h",1x:"c-5-2Z",19:"c-5-4U",1B:"c-5-4T"};A.c.5.30="l";A.1u(A.c.5.1k,{2d:p,4V:4(C,F){F=F||f;b B=2,E=2.d.e;4 G(){B.2d=4W(4(){E=++E<B.$5.l?E:0;B.1m(E)},C)}4 D(H){6(!H||H.4Y){4X(B.2d)}}6(C){G();6(!F){2.$5.w(2.d.18,D)}r{2.$5.w(2.d.18,4(){D();E=B.d.e;G()})}}r{D();2.$5.12(2.d.18,D)}}})})(2l);',62,347,'||this||function|tabs|if|return||||var|ui|options|selected|false||disabled|data|panels|element|length|lis|addClass|selectedClass|null|css|else||href|removeClass|load|bind|attr|true|each|||||||||||||||||||||browser|filter|eq|cookie|index|_mouseStarted||remove|unbind||_trigger|hash|||event|hideClass|test|cache|widgetName|add|msie|disabledClass|destroy|fx|string|hasClass|prototype|replace|select|undefined|_setData|widget|display|typeof|unselectable|id|extend|inArray|_tabify|panelClass|removeData|defaults|_mouseUp|loadingClass|cssCache|block|map|html|apply|_mouseDownEvent|plugins|xhr|setTimeout|label|ajaxOptions|blur|li|spinner|mouseDelayMet|unselect|stop|get|_getData|Math|_init|widgetEventPrefix|none|disable||_mouseDrag|panelTemplate|div|delay|navClass|unselectClass||for|push|enable|cancel|_mouseDelayMet|rotation|opacity|click|style|success|duration|split|_|jQuery|target|_mouseDistanceMet|fn|appendTo|_tabId|_mouseUpDelegate|hidden|find|em|_mouseStart|show|location|_mouseMoveDelegate|distance|mouse|overflow|concat|type|widgetBaseClass|triggerHandler|title|call|5000px|width|option|getterSetter|parents|animate|height|Array|arguments|metadata|mousemove|span|_mouseUnselectable|tabTemplate|idPrefix|url|_mouseCapture|panel|getter|selectstart|||||||||MozUserSelect|left|body|on|_mouseMove|_mouseDown|abs|pageX|parentNode|insertBefore|grep|sort|pageY|_mouseStop|button|mouseup|document|removeChild|catch|absolute|top|rgba|position|backgroundImage|cursor|auto|transparent|backgroundColor|default|try|PERIOD|ENTER|ESCAPE|END|DOWN|CONTROL|DELETE|HOME|INSERT|NUMPAD_DECIMAL|110|107|NUMPAD_ADD|LEFT|188|COMMA|tabbable|nodeName|expr|dir|visibility|toLowerCase||tabIndex|BACKSPACE|CAPS_LOCK|keyCode|||textarea|input|NUMPAD_DIVIDE|111|new|isFunction|substring|slice|UP|eventPrefix|setData|in|class|plugin|fix|getData|TAB|SPACE|106|NUMPAD_SUBTRACT|NUMPAD_MULTIPLY|108|NUMPAD_ENTER|109|PAGE_DOWN|RIGHT|SHIFT|190|disableSelection|PAGE_UP|gen|unique|enableSelection|child|inline|trigger|is|last|first|indexOf|UI|throw|Tabs|Mismatching|identifier|fragment|not|img|loading|hide|rotate|setInterval|clearInterval|clientX|nav|8230|wrapInner|parent|abort|ajax|Loading|join|visible|safari|scrollTop|z0|Za|tab|has|opera|insertAfter|_mouseInit|mousedown|preventDefault|which|_mouseDelayTimer|_mouseDestroy|max|started|siblings|500|scrollLeft|off|normal|window|constructor|unload|parseInt|min|scrollTo|hasScroll|splice'.split('|'),0,{}))
function countdown(leftoverTime,maxDigits){if(maxDigits==null||maxDigits==""){maxDigits=2;}
var thisObj=this;thisObj.timestamp=0;thisObj.maxDigits=maxDigits;thisObj.delimiter=" ";thisObj.approx="";thisObj.showunits=true;thisObj.zerofill=false;var localTime=new Date();thisObj.startTime=localTime.getTime();thisObj.startLeftoverTime=leftoverTime;this.getCurrentTimestring=function(){return thisObj.formatTime(thisObj.getLeftoverTime());}
this.getLeftoverTime=function(){var currTime=new Date();return Math.round((thisObj.startLeftoverTime-(currTime.getTime()-thisObj.startTime)/1000));}
this.formatTime=function(timestamp){maxDigits=thisObj.maxDigits;var timeunits=new Array;timeunits.day=86400;timeunits.hour=3600;timeunits.minute=60;timeunits.second=1;var loca=new Array;loca.day=thisObj.showunits?LocalizationStrings.timeunits['short'].day:"";loca.hour=thisObj.showunits?LocalizationStrings.timeunits['short'].hour:"";loca.minute=thisObj.showunits?LocalizationStrings.timeunits['short'].minute:"";loca.second=thisObj.showunits?LocalizationStrings.timeunits['short'].second:"";var timestring="";for(var k in timeunits){var nv=Math.floor(timestamp/timeunits[k]);if(maxDigits>0&&(nv>0||thisObj.zerofill&&timestring!="")){timestamp=timestamp-nv*timeunits[k];if(timestring!=""){timestring+=thisObj.delimiter;if(nv<10&&nv>0&&thisObj.zerofill){nv="0"+nv;}
if(nv==0){nv="00";}}
timestring+=nv+loca[k];maxDigits--;}}
if(timestamp>0){timestring=thisObj.approx+timestring;}
return timestring;}}
function bauCountdown(htmlObj,leftoverTime,totalTime,reloadPage){if(typeof(htmlObj)=='object'){var thisObj=this;thisObj.totalTime=totalTime;thisObj.startHeight=htmlObj.offsetHeight;thisObj.htmlObj=htmlObj;thisObj.timeHtmlObj=getChildNodeWithClassName(htmlObj,'time');this.updateCountdown=function(){thisObj.countdown.getCurrentTimestring();timestamp=thisObj.countdown.getLeftoverTime();timestring=thisObj.countdown.getCurrentTimestring();thisObj.timeHtmlObj.innerHTML=timestring;var faktor=Math.max(0,timestamp)/thisObj.totalTime;if(faktor>0){height=Math.round(thisObj.startHeight*(1-(faktor)));thisObj.htmlObj.style.height=height+'px';thisObj.htmlObj.style.marginBottom='-'+height+'px';}else{thisObj.timeHtmlObj.innerHTML=LocalizationStrings.status.ready;height=thisObj.startHeight;thisObj.htmlObj.style.height=height+'px';thisObj.htmlObj.style.marginBottom='-'+height+'px';if(timestamp<=-1)
{reload_page(reloadPage);}}
setTimeout(thisObj.updateCountdown,1000);}
if(thisObj.timeHtmlObj){thisObj.countdown=new countdown(leftoverTime);thisObj.updateCountdown();}else{window.status='kein timeHtmlObj';}}}
function schiffbauCountdown(htmlObj,shipCount,currentShips,leftoverTime,oneShipTime,reloadPage){if(typeof(htmlObj)=='object'){var thisObj=this;thisObj.totalTime=oneShipTime;thisObj.oneShipTime=oneShipTime;thisObj.shipCount=shipCount;thisObj.currentShips=currentShips;thisObj.startHeight=htmlObj.offsetHeight;thisObj.htmlObj=htmlObj;thisObj.timeHtmlObj=getChildNodeWithClassName(htmlObj,'time');thisObj.countHtmlObj=getChildNodeWithClassName(htmlObj.parentNode,'count');thisObj.shipsHtmlObj=getChildNodeWithClassName(htmlObj.parentNode,'level');this.updateCountdown=function(){thisObj.countdown.getCurrentTimestring();timestamp=thisObj.countdown.getLeftoverTime();timestring=thisObj.countdown.getCurrentTimestring();thisObj.replaceInnerHTML(thisObj.timeHtmlObj,timestring);var faktor=Math.max(0,timestamp)/thisObj.totalTime;if(faktor>0){height=Math.round(thisObj.startHeight*(1-(faktor)));thisObj.htmlObj.style.height=height+'px';thisObj.htmlObj.style.marginBottom='-'+height+'px';setTimeout(thisObj.updateCountdown,1000);}else{thisObj.shipCount--;thisObj.currentShips++;if(thisObj.shipCount>=0){thisObj.replaceInnerHTML(thisObj.countHtmlObj,thisObj.shipCount);if(typeof document.getElementById("sumCount")!="undefined"){document.getElementById("sumCount").innerHTML=thisObj.shipCount;}}
thisObj.replaceInnerHTML(thisObj.shipsHtmlObj,gfNumberGetHumanReadable(thisObj.currentShips));if(thisObj.shipCount>0){thisObj.countdown=new countdown(oneShipTime);thisObj.replaceInnerHTML(thisObj.timeHtmlObj,'-');}else{thisObj.replaceInnerHTML(thisObj.timeHtmlObj,LocalizationStrings.status.ready);if(timestamp<=-1)
{reload_page(reloadPage);}}
setTimeout(thisObj.updateCountdown,1000);}}
this.replaceInnerHTML=function(obj,val){var htmlNode=document.createTextNode(val);if(obj.firstChild){obj.firstChild.deleteData(0,20)
obj.firstChild.appendData(htmlNode.nodeValue);}}
if(thisObj.timeHtmlObj&&thisObj.countHtmlObj&&thisObj.shipsHtmlObj){thisObj.countdown=new countdown(leftoverTime);thisObj.updateCountdown();}else{window.status='kein: timeHtmlObj oder countHtmlObj oder shipsHtmlObj';}}}
function baulisteCountdown(htmlObj,leftoverTime,reloadPage){if(typeof(htmlObj)=='object'){var thisObj=this;thisObj.timeHtmlObj=htmlObj;this.updateCountdown=function(){thisObj.countdown.getCurrentTimestring();timestamp=thisObj.countdown.getLeftoverTime();timestring=thisObj.countdown.getCurrentTimestring();if(timestamp>0){thisObj.timeHtmlObj.innerHTML=timestring;}else{thisObj.timeHtmlObj.innerHTML=LocalizationStrings.status.ready;if(timestamp<=-1)
{reload_page(reloadPage);}}
setTimeout(thisObj.updateCountdown,1000);}
if(thisObj.timeHtmlObj){thisObj.countdown=new countdown(leftoverTime);thisObj.updateCountdown();}}}
function eventCountdown(htmlObj){if(typeof(htmlObj)=='object'){var thisObj=this;var leftoverTime=0;var id=htmlObj.id;var idSplit=id.split("-");var onreadyFunction=null;var onreadyParam=null;if(idSplit[2]==0)
{leftoverTime=idSplit[1];}
else if(idSplit[2]==1)
{leftoverTime=parseInt(idSplit[1])+parseInt(Math.round((new Date().getTime()/1000)));}
if(idSplit[3])
{onreadyFunction=idSplit[3];}
if(idSplit[4])
{onreadyParam=idSplit[4];}
thisObj.timeHtmlObj=htmlObj;this.updateCountdown=function(){thisObj.countdown.getCurrentTimestring();timestamp=thisObj.countdown.getLeftoverTime();timestring=thisObj.countdown.getCurrentTimestring();if(timestamp>0){thisObj.timeHtmlObj.innerHTML=timestring;setTimeout(thisObj.updateCountdown,1000);}else{thisObj.timeHtmlObj.innerHTML=LocalizationStrings.status.ready;if(onreadyFunction&&typeof onreadyFunction!="undefined"){window[onreadyFunction](onreadyParam);onreadyFunction=null;onreadyParam=null;}}}
if(thisObj.timeHtmlObj){thisObj.countdown=new countdown(leftoverTime,3);thisObj.updateCountdown();}}}
function load_eventCountdown()
{var allCountdownNodes=document.getElementsByTagName('*');for(i in allCountdownNodes){if(allCountdownNodes[i].attributes&&allCountdownNodes[i].attributes['name']&&allCountdownNodes[i].attributes['name'].nodeValue=='countdown'){var eventNode=allCountdownNodes[i];var temp=new eventCountdown(eventNode);}}}
reloaded=0;function reload_page(url)
{if(reloaded==0)
{location.href=url;reloaded++;}}
function countdownStart(type)
{var allCountdownNodes=document.getElementsByName(type);for(i in allCountdownNodes){var eventNode=allCountdownNodes[i];var temp=new eventCountdown(eventNode);}}
function resourceTicker(config){var thisObj=this;thisObj.config=config;thisObj.htmlObj=document.getElementById(thisObj.config.valueElem);var localTime=new Date();thisObj.startTime=localTime.getTime();thisObj.updateResource=function(){var localTime=new Date().getTime();nrResource=thisObj.config.available+thisObj.config.production*(localTime-thisObj.startTime)/1000;nrResource=Math.round(nrResource);if(nrResource>=thisObj.config.limit[1]){nrResource=thisObj.config.limit[1];thisObj.htmlObj.style.color='#ff0000';}
nrResource=gfNumberGetHumanReadable(nrResource);thisObj.htmlObj.innerHTML=nrResource;}
if(config.intervalObj){clearInterval(config.intervalObj);}
config.intervalObj=setInterval(thisObj.updateResource,200);}
var tb_pathToImage="img/cluetip/wait.gif";$(document).ready(function(){tb_init('a.thickbox, area.thickbox, input.thickbox, a.ajax_thickbox');imgLoader=new Image();imgLoader.src=tb_pathToImage;});function tb_init(domChunk){$(domChunk).click(function(){var t=this.title||this.name||null;var a=this.href||this.alt;var g=this.rel||false;tb_show(t,a,g);this.blur();return false;});}
function tb_show(caption,url,imageGroup){try{if(typeof document.body.style.maxHeight==="undefined"){$("body","html").css({height:"100%",width:"100%"});$("html").css("overflow","hidden");if(document.getElementById("TB_HideSelect")===null){$("body").append("<iframe id='TB_HideSelect'></iframe><div id='TB_overlay'></div><div id='TB_window'></div>");$("#TB_overlay").click(tb_remove);}}else{if(document.getElementById("TB_overlay")===null){$("body").append("<div id='TB_overlay'></div><div id='TB_window'></div>");$("#TB_overlay").click(tb_remove);}}
if(tb_detectMacXFF()){$("#TB_overlay").addClass("TB_overlayMacFFBGHack");}else{$("#TB_overlay").addClass("TB_overlayBG");}
if(caption===null){caption="";}
$("body").append("<div id='TB_load'><img src='"+imgLoader.src+"' /></div>");$('#TB_load').show();var baseURL;if(url.indexOf("?")!==-1){baseURL=url.substr(0,url.indexOf("?"));}else{baseURL=url;}
var urlString=/\.jpg$|\.jpeg$|\.png$|\.gif$|\.bmp$/;var urlType=baseURL.toLowerCase().match(urlString);if(urlType=='.jpg'||urlType=='.jpeg'||urlType=='.png'||urlType=='.gif'||urlType=='.bmp'){TB_PrevCaption="";TB_PrevURL="";TB_PrevHTML="";TB_NextCaption="";TB_NextURL="";TB_NextHTML="";TB_imageCount="";TB_FoundURL=false;if(imageGroup){TB_TempArray=$("a[@rel="+imageGroup+"]").get();for(TB_Counter=0;((TB_Counter<TB_TempArray.length)&&(TB_NextHTML===""));TB_Counter++){var urlTypeTemp=TB_TempArray[TB_Counter].href.toLowerCase().match(urlString);if(!(TB_TempArray[TB_Counter].href==url)){if(TB_FoundURL){TB_NextCaption=TB_TempArray[TB_Counter].title;TB_NextURL=TB_TempArray[TB_Counter].href;TB_NextHTML="<span id='TB_next'>&nbsp;&nbsp;<a href='#'>Next &gt;</a></span>";}else{TB_PrevCaption=TB_TempArray[TB_Counter].title;TB_PrevURL=TB_TempArray[TB_Counter].href;TB_PrevHTML="<span id='TB_prev'>&nbsp;&nbsp;<a href='#'>&lt; Prev</a></span>";}}else{TB_FoundURL=true;TB_imageCount="Image "+(TB_Counter+1)+" of "+(TB_TempArray.length);}}}
imgPreloader=new Image();imgPreloader.onload=function(){imgPreloader.onload=null;var pagesize=tb_getPageSize();var x=pagesize[0]-150;var y=pagesize[1]-150;var imageWidth=imgPreloader.width;var imageHeight=imgPreloader.height;if(imageWidth>x){imageHeight=imageHeight*(x/imageWidth);imageWidth=x;if(imageHeight>y){imageWidth=imageWidth*(y/imageHeight);imageHeight=y;}}else if(imageHeight>y){imageWidth=imageWidth*(y/imageHeight);imageHeight=y;if(imageWidth>x){imageHeight=imageHeight*(x/imageWidth);imageWidth=x;}}
TB_WIDTH=imageWidth+30;TB_HEIGHT=imageHeight+60;$("#TB_window").append("<a href='' id='TB_ImageOff' title='Close'><img id='TB_Image' src='"+url+"' width='"+imageWidth+"' height='"+imageHeight+"' alt='"+caption+"'/></a>"+"<div id='TB_caption'>"+caption+"<div id='TB_secondLine'>"+TB_imageCount+TB_PrevHTML+TB_NextHTML+"</div></div><div id='TB_closeWindow'><a href='#' id='TB_closeWindowButton' title='Close'>close</a> or Esc Key</div>");$("#TB_closeWindowButton").click(tb_remove);if(!(TB_PrevHTML==="")){function goPrev(){if($(document).unbind("click",goPrev)){$(document).unbind("click",goPrev);}
$("#TB_window").remove();$("body").append("<div id='TB_window'></div>");tb_show(TB_PrevCaption,TB_PrevURL,imageGroup);return false;}
$("#TB_prev").click(goPrev);}
if(!(TB_NextHTML==="")){function goNext(){$("#TB_window").remove();$("body").append("<div id='TB_window'></div>");tb_show(TB_NextCaption,TB_NextURL,imageGroup);return false;}
$("#TB_next").click(goNext);}
document.onkeydown=function(e){if(e==null){keycode=event.keyCode;}else{keycode=e.which;}
if(keycode==27){tb_remove();}else if(keycode==190){if(!(TB_NextHTML=="")){document.onkeydown="";goNext();}}else if(keycode==188){if(!(TB_PrevHTML=="")){document.onkeydown="";goPrev();}}};tb_position();$("#TB_load").remove();$("#TB_ImageOff").click(tb_remove);$("#TB_window").css({display:"block"});};imgPreloader.src=url;}else{var queryString=url.replace(/^[^\?]+\??/,'');var params=tb_parseQuery(queryString);TB_WIDTH=(params['width']*1)+30||630;TB_HEIGHT=(params['height']*1)+40||440;ajaxContentW=TB_WIDTH-30;ajaxContentH=TB_HEIGHT-45;if(url.indexOf('TB_iframe')!=-1){urlNoQuery=url.split('TB_');$("#TB_iframeContent").remove();if(params['modal']!="true"){$("#TB_window").append("<iframe allowTransparency='true' frameborder='0' hspace='0' src='"+urlNoQuery[0]+"' id='TB_iframeContent' name='TB_iframeContent"+Math.round(Math.random()*1000)+"' onload='tb_showIframe()' style='width:"+(ajaxContentW+29)+"px;height:"+(ajaxContentH+17)+"px;' > </iframe>");}else{$("#TB_overlay").unbind();$("#TB_window").append("<iframe allowTransparency='true' frameborder='0' hspace='0' src='"+urlNoQuery[0]+"' id='TB_iframeContent' name='TB_iframeContent"+Math.round(Math.random()*1000)+"' onload='tb_showIframe()' style='background-color: transparent;width:"+(ajaxContentW+29)+"px;height:"+(ajaxContentH+17)+"px;'> </iframe>");}}else{if($("#TB_window").css("display")!="block"){if(params['modal']!="true"){$("#TB_window").append("<div id='TB_ajaxContent' style='width:"+ajaxContentW+"px;height:"+ajaxContentH+"px'></div>");}else{$("#TB_overlay").unbind();$("#TB_window").append("<div id='TB_ajaxContent' class='TB_modal' style='width:"+ajaxContentW+"px;height:"+ajaxContentH+"px;'></div>");}}else{$("#TB_ajaxContent")[0].style.width=ajaxContentW+"px";$("#TB_ajaxContent")[0].style.height=ajaxContentH+"px";$("#TB_ajaxContent")[0].scrollTop=0;$("#TB_ajaxWindowTitle").html(caption);}}
$("#TB_closeWindowButton").click(tb_remove);if(url.indexOf('TB_inline')!=-1){$("#TB_ajaxContent").append($('#'+params['inlineId']).children());$("#TB_window").unload(function(){$('#'+params['inlineId']).append($("#TB_ajaxContent").children());});tb_position();$("#TB_load").remove();$("#TB_window").css({display:"block"});}else if(url.indexOf('TB_iframe')!=-1){tb_position();if($.browser.safari){$("#TB_load").remove();$("#TB_window").css({display:"block"});}}else{$("#TB_ajaxContent").load(url+="&random="+(new Date().getTime()),function(){tb_position();$("#TB_load").remove();tb_init("#TB_ajaxContent a.thickbox");$("#TB_window").css({display:"block"});AjaxCluetip();});}}
if(!params['modal']){document.onkeyup=function(e){if(e==null){keycode=event.keyCode;}else{keycode=e.which;}
if(keycode==27){tb_remove();}};}}catch(e){}}
function tb_showIframe(){$("#TB_load").remove();$("#TB_window").css({display:"block"});}
function tb_remove(parent_func_callback){$("#TB_imageOff").unbind("click");$("#TB_closeWindowButton").unbind("click");$("#TB_window").fadeOut("fast",function(){$('#TB_window,#TB_overlay,#TB_HideSelect').trigger("unload").unbind().remove();});$("#TB_load").remove();if(typeof document.body.style.maxHeight=="undefined"){$("body","html").css({height:"auto",width:"auto"});$("html").css("overflow","");}
if(parent_func_callback!=undefined)
eval("window."+parent_func_callback);document.onkeydown="";document.onkeyup="";return false;}
function tb_position(){$("#TB_window").css({marginLeft:'-'+parseInt((TB_WIDTH/2),10)+'px',width:TB_WIDTH+'px'});if(!(jQuery.browser.msie&&jQuery.browser.version<7)){$("#TB_window").css({marginTop:'-'+parseInt((TB_HEIGHT/2),10)+'px'});}}
function tb_parseQuery(query){var Params={};if(!query){return Params;}
var Pairs=query.split(/[;&]/);for(var i=0;i<Pairs.length;i++){var KeyVal=Pairs[i].split('=');if(!KeyVal||KeyVal.length!=2){continue;}
var key=unescape(KeyVal[0]);var val=unescape(KeyVal[1]);val=val.replace(/\+/g,' ');Params[key]=val;}
return Params;}
function tb_getPageSize(){var de=document.documentElement;var w=window.innerWidth||self.innerWidth||(de&&de.clientWidth)||document.body.clientWidth;var h=window.innerHeight||self.innerHeight||(de&&de.clientHeight)||document.body.clientHeight;arrayPageSize=[w,h];return arrayPageSize;}
function tb_detectMacXFF(){var userAgent=navigator.userAgent.toLowerCase();if(userAgent.indexOf('mac')!=-1&&userAgent.indexOf('firefox')!=-1){return true;}}
var jThickboxNewLink;function tb_remove_open(reloadLink){jThickboxReloadLink=reloadLink;tb_remove();setTimeout("jThickboxNewLink();",500);return false;}
function tb_open_new(jThickboxNewLink){tb_show(null,jThickboxNewLink,null);}
var x="";var e=null;function cntchar(m){if(window.document.forms[0].text.value.length>m){window.document.forms[0].text.value=x;}else{x=window.document.forms[0].text.value;}
if(e==null)
e=document.getElementById('cntChars');else
e.childNodes[0].data=window.document.forms[0].text.value.length;}
function reloadEventbox(data)
{var data=eval('('+data+')');if(typeof data["eventText"]!="undefined"){$("#eventFriendly").html(data["friendly"]);$("#eventNeutral").html(data["neutral"]);$("#eventHostile").html(data["hostile"]);$("#eventContent").html(data["eventText"]);$('#tempcounter').attr('id','countdown_start-'+data["eventTime"]+'-0-initAjaxEventbox');$("#eventClass").attr('class',data["eventText"]);}
$("#eventboxLoading").hide();if(typeof data["eventText"]=="undefined"){$("#eventboxBlank").show();$("#eventboxFilled").hide();}else{$("#eventboxBlank").hide();$("#eventboxFilled").show();load_eventCountdown();}}
function reloadResources(resources)
{var data=eval('('+resources+')');$("#resources_metal").html(data["metal"]["resources"]["actualFormat"]);$("#resources_metal").attr('class',data["metal"]["class"]);$("#metal_box").attr('title',"|"+data["metal"]["tooltip"]);$("#resources_crystal").html(data["crystal"]["resources"]["actualFormat"]);$("#resources_crystal").attr('class',data["crystal"]["class"]);$("#crystal_box").attr('title',"|"+data["crystal"]["tooltip"]);$("#resources_deuterium").html(data["deuterium"]["resources"]["actualFormat"]);$("#resources_deuterium").attr('class',data["deuterium"]["class"]);$("#deuterium_box").attr('title',"|"+data["deuterium"]["tooltip"]);$("#resources_energy").html(data["energy"]["resources"]["actualFormat"]);$("#resources_energy").attr('class',data["energy"]["class"]);$("#energy_box").attr('title',"|"+data["energy"]["tooltip"]);$("#resources_darkmatter").html(data["darkmatter"]["resources"]["actualFormat"]);$("#resources_darkmatter").attr('class',data["darkmatter"]["class"]);$("#darkmatter_box").attr('title',"|"+data["darkmatter"]["tooltip"]);reloadCluetip();reloadResourceTicker(resources);}
function reloadResourceTicker(resources)
{var data=eval('('+resources+')');resourceTickerMetal.available=data["metal"]["resources"]["actual"];resourceTickerMetal.limit=[data["metal"]["resources"]["actual"],data["metal"]["resources"]["max"]];resourceTickerMetal.production=data["metal"]["resources"]["production"];resourceTickerMetal.valueElem="resources_metal";resourceTickerCrystal.available=data["crystal"]["resources"]["actual"];resourceTickerCrystal.limit=[data["crystal"]["resources"]["actual"],data["crystal"]["resources"]["max"]];resourceTickerCrystal.production=data["crystal"]["resources"]["production"];resourceTickerCrystal.valueElem="resources_crystal";resourceTickerDeuterium.available=data["deuterium"]["resources"]["actual"];resourceTickerDeuterium.limit=[data["deuterium"]["resources"]["actual"],data["deuterium"]["resources"]["max"]];resourceTickerDeuterium.production=data["deuterium"]["resources"]["production"];resourceTickerDeuterium.valueElem="resources_deuterium";new resourceTicker(resourceTickerMetal);new resourceTicker(resourceTickerCrystal);new resourceTicker(resourceTickerDeuterium);}
function reloadRightmenu(url)
{$.get(url,{},displayRightmenu);}
function displayRightmenu(data)
{$("#rechts").html(data);reloadCluetip();}
function ajaxFormSubmit(form,url,okFunction)
{var params=$("#"+form+"").serialize();var successFunction=null;if(okFunction!=null&&typeof okFunction=="function")
{successFunction=okFunction;}
$.ajax({type:"POST",url:url,data:params,success:successFunction});}
var errorBoxYesHandler=0;var errorBoxNoHandler=0;var errorBoxOkHandler=0;function errorBoxAsArray(data)
{if(data["type"]=="notify"){notifyBoxAsArray(data);}else if(data["type"]=="decision"){errorBoxDecision(data);}}
function notifyBoxAsArray(data){errorBoxNotify(data["title"],data["text"],data["buttonOk"],String(data["okFunction"]),data["removeOpen"],data["modal"]);}
function decisionBoxAsArray(data){errorBoxDecision(data["title"],data["text"],data["buttonOk"],data["buttonNOk"],String(data["okFunction"]),String(data["nokFunction"]),data["removeOpen"],data["modal"]);}
function errorBoxDecision(head,content,yes,no,yesHandler,noHandler,removeOpen,modal)
{document.getElementById("errorBoxDecisionHead").innerHTML=head;document.getElementById("errorBoxDecisionContent").innerHTML=content;document.getElementById("errorBoxDecisionYes").innerHTML=yes;document.getElementById("errorBoxDecisionNo").innerHTML=no;if(yesHandler!=null){errorBoxYesHandler=yesHandler;}
if(noHandler!=null){errorBoxNoHandler=noHandler;}
if(removeOpen!=null&&removeOpen==true){tb_remove_openNew('#TB_inline?height=200&width=400&inlineId=decisionTB&modal=true');}else{tb_open('#TB_inline?height=200&width=400&inlineId=decisionTB&modal=true');}}
function errorBoxNotify(head,content,ok,okHandler,removeOpen,modal)
{document.getElementById("errorBoxNotifyHead").innerHTML=head;document.getElementById("errorBoxNotifyContent").innerHTML=content;document.getElementById("errorBoxNotifyOk").innerHTML=ok;if(okHandler!=null){errorBoxOkHandler=okHandler;}
if(removeOpen!=null&&removeOpen==true){if(modal==true||modal=="true"){tb_remove_openNew('#TB_inline?height=200&width=400&inlineId=notifyTB&modal=true');}else{tb_remove_openNew('#TB_inline?height=200&width=400&inlineId=notifyTB');}}else{if(modal||modal=="true"){tb_open('#TB_inline?height=200&width=400&inlineId=notifyTB&modal=true');}else{tb_open('#TB_inline?height=200&width=400&inlineId=notifyTB');}}}
function closeErrorBox()
{tb_remove();errorBoxYesHandler=0;errorBoxNoHandler=0;}
function handleErrorBoxClick(buttonType)
{if(buttonType=='ok')
{if(typeof errorBoxOkHandler=="string"&&$.isFunction(window[errorBoxOkHandler]))
{window[errorBoxOkHandler]();}
else if($.isFunction(errorBoxOkHandler))
{errorBoxOkHandler();}
else if(typeof errorBoxSubmitOk!="undefined"&&$.isFunction(errorBoxSubmitOk))
{errorBoxSubmitOk();}
else
{closeErrorBox();}}
else if(buttonType=='yes')
{if(typeof errorBoxYesHandler=="string"&&$.isFunction(window[errorBoxYesHandler]))
{window[errorBoxYesHandler]();}
else if($.isFunction(errorBoxYesHandler))
{errorBoxYesHandler();}
else if(typeof errorBoxSubmitYes!="undefined"&&$.isFunction(errorBoxSubmitYes))
{errorBoxSubmitYes();}
else
{closeErrorBox();}}
else if(buttonType=='no')
{if(typeof errorBoxNoHandler=="string"&&$.isFunction(window[errorBoxNoHandler]))
{window[errorBoxNoHandler]();}
else if($.isFunction(errorBoxNoHandler))
{errorBoxNoHandler();}
else if(typeof errorBoxSubmitNo!="undefined"&&$.isFunction(errorBoxSubmitNo))
{errorBoxSubmitNo();}
else
{closeErrorBox();}}}
function tsdpkt(f)
{r="";vz="";if(f<0)
{vz="-";}
f=Math.abs(f);r=f%1000;while(f>=1000)
{k1="";if((f%1000)<100)
{k1="0";}
if((f%1000)<10)
{k1="00";}
if((f%1000)==0)
{k1="00";}
f=Math.abs((f-(f%1000))/1000);r=f%1000+"."+k1+r;}
r=vz+r;return r;}
function formatTime(seconds)
{var hours=Math.floor(seconds/3600);seconds-=hours*3600;var minutes=Math.floor(seconds/60);seconds-=minutes*60;if(minutes<10)minutes="0"+minutes;if(seconds<10)seconds="0"+seconds;return hours+":"+minutes+":"+seconds;}
function trimInteger(value)
{value=value.replace(/^\s+|\s+$/g,'');withoutZero=value.replace(/^0+/g,"");if(withoutZero==""&&value!="")
{return 0;}
else
{return withoutZero;}}
function show_hide_menus(element)
{if(document.getElementById(element).style.display=="block")
{document.getElementById(element).style.display="none";}
else
{document.getElementById(element).style.display="block";}}
function change_class(ele)
{if(document.getElementById(ele).className=="closed")
{document.getElementById(ele).className="opened";}
else
{document.getElementById(ele).className="closed";}}
function show_hide_tbl(id)
{var el=document.getElementById(id);try
{if(el)el.style.display=(el.style.display=="none"?"table-row":"none");}
catch(e)
{el.style.display="block";}}
function createExpireTime(timestamp)
{var date=new Date();timestamp=timestamp*1000;date.setTime(timestamp);return date;}
function deleteSetCookie(name,expire)
{if($.cookie(name)==true){$.cookie(name,null);}else{var date=createExpireTime(expire);$.cookie(name,'1',{expires:date});}}
function changeCookie(name,expire)
{var date=createExpireTime(expire);if($.cookie(name)==1){$.cookie(name,'0',{expires:date});}else{$.cookie(name,'1',{expires:date});}}
function set_cookie(ele,expire)
{expireStatement="";if(expire!="")
{var expireTime=new Date();expire=expire*1000;expireTime.setTime(expire);expireStatement=' expires='+expireTime.toGMTString()+'';}
if(document.cookie)
{done=false;cookie_object=document.cookie.replace(/ /g,"");cookie_explode=cookie_object.split(";");for(i=0;i<cookie_explode.length;i++)
{data_explode=cookie_explode[i].split("=");if(data_explode[0]==ele)
{if(data_explode[1]==0)
{document.cookie=''+ele+'=1;'+expireStatement+'';}
else
{document.cookie=''+ele+'=0;'+expireStatement+'';}
done=true;break;}}
if(!done)
{document.cookie=''+ele+'=0;'+expireStatement+'';}}
else
{document.cookie=''+ele+'=0;'+expireStatement+'';}}
function check_cookie(cookieName,ele)
{if(document.cookie)
{done=false;cookie_object=document.cookie.replace(/ /g,"");cookie_explode=cookie_object.split(";");for(i=0;i<cookie_explode.length;i++)
{data_explode=cookie_explode[i].split("=");if(data_explode[0]==cookieName)
{if(data_explode[1]==0)
{cookie_isNotSet(ele);}
else
{cookie_isSet(ele);}
done=true;break;}}
if(!done)
{cookie_isNotSet(ele);}}
else
{cookie_isNotSet(ele);}}
var days=new Array('Mon','Tus','Wed','Thu','Fri','Sat','Sun');var months=new Array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");function getFormatedDate(timestamp,format){var currTime=new Date();currTime.setTime(timestamp);str=format;str=str.replace('[d]',dezInt(currTime.getDate(),2));str=str.replace('[D]',days[currTime.getDay()]);str=str.replace('[m]',dezInt(currTime.getMonth()+1,2));str=str.replace('[M]',months[currTime.getMonth()]);str=str.replace('[j]',parseInt(currTime.getDate()));str=str.replace('[Y]',currTime.getFullYear());str=str.replace('[y]',currTime.getFullYear().toString().substr(2,4));str=str.replace('[G]',currTime.getHours());str=str.replace('[H]',dezInt(currTime.getHours(),2));str=str.replace('[i]',dezInt(currTime.getMinutes(),2));str=str.replace('[s]',dezInt(currTime.getSeconds(),2));return str;}
function dezInt(num,size,prefix){prefix=(prefix)?prefix:"0";var minus=(num<0)?"-":"",result=(prefix=="0")?minus:"";num=Math.abs(parseInt(num,10));size-=(""+num).length;for(var i=1;i<=size;i++){result+=""+prefix;}
result+=((prefix!="0")?minus:"")+num;return result;}
function getFormatedTime(time)
{hours=Math.floor(time/3600);timeleft=time%3600;minutes=Math.floor(timeleft/60);timeleft=timeleft%60;seconds=timeleft;return dezInt(hours,2)+":"+dezInt(minutes,2)+":"+dezInt(seconds,2);}