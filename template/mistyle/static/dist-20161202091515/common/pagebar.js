define(["require"],function(e){var t=10,a={};return a.render=function(e,a,r,v,i){var c=Math.ceil(v/r),u=[];a>1&&(u=[{text:"首页",value:1,active:!0},{text:"上一页",value:a-1,active:!0}]);for(var l=[],n=Math.ceil(t/2),f=n>=a?1:a-n,o=0;t>o;){var h=f!=a,x={text:f,value:f,active:h};if(l.push(x),++f,f>c)break;++o}var s=[];if(c>0&a!=c)var s=[{text:"下一页",value:a+1,active:!0},{text:"尾页",value:c,active:!0}];for(var g=u.concat(l,s),d="",M=0;M<g.length;++M){var b=g[M].text,j=g[M].value;if(g[M].active){var k=i+j;d+='<a href="'+k+'">'+b+"</a>"}else d+="<strong>"+b+"</strong>"}jQuery("#"+e).html(d)},a});