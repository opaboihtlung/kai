import{$ as m,A as b,S as E,E as w}from"./index.es-Dvo41eUP.js";import{u as T}from"./utils-f6ewzwJT.js";import{A as o,L as k,o as p,c as g,w as l,a as r,u as s,g as a,t as _,m as B}from"./app-CD2aFJMz.js";const O={style:{"text-align":"center"}},A={class:"text-weight-medium text-primary"},C=a("div",{class:"text-caption"},"Sign-in from here",-1),M=a("img",{src:"/assets/images/emp.jpeg",width:"20",height:"50",style:{"margin-top":"8px"}},null,-1),P=a("div",{style:{"text-align":"center"}},[a("div",{class:"text-caption"},"I am sign-out from here"),a("img",{src:"/assets/images/emp.jpeg",width:"20",height:"50",style:{"margin-top":"8px"}})],-1),S={class:"text-caption"},R={__name:"Geolocation",props:["attendance"],setup(u){const{MAP_KEY:f}=T(),n=u,h=o(()=>{var t,e;return{lat:Number((t=n.attendance)==null?void 0:t.lat),lng:Number((e=n.attendance)==null?void 0:e.lng)}}),N=o(()=>{var t,e;return{lat:Number((t=n.attendance)==null?void 0:t.signout_lat),lng:Number((e=n.attendance)==null?void 0:e.signout_lng)}}),d=o(()=>{var t,e;return{lat:Number((t=n.attendance)==null?void 0:t.office.lat),lng:Number((e=n.attendance)==null?void 0:e.office.lng)}}),v=o(()=>{var t,e,i;return{center:{lat:Number((t=n.attendance)==null?void 0:t.office.lat),lng:Number((e=n.attendance)==null?void 0:e.office.lng)},radius:Number((i=n.attendance)==null?void 0:i.office.radius)}}),x=o(()=>{var t;return(t=n.attendance)==null?void 0:t.user}),y=o(()=>{var t;return(t=n.attendance)==null?void 0:t.office});return k(()=>{}),(t,e)=>(p(),g(s(w),{"api-key":s(f),style:{width:"100%",height:"550px"},center:d.value,zoom:20},{default:l(()=>{var i;return[r(s(m),{options:{position:h.value,anchorPoint:"BOTTOM_CENTER"}},{default:l(()=>{var c;return[a("div",O,[a("div",A,"Hi my name is "+_((c=x.value)==null?void 0:c.full_name),1),C,M])]}),_:1},8,["options"]),(i=u.attendance)!=null&&i.signout_lat?(p(),g(s(m),{key:0,options:{position:N.value,anchorPoint:"BOTTOM_CENTER"}},{default:l(()=>[P]),_:1},8,["options"])):B("",!0),r(s(b),{options:{position:d.value}},{default:l(()=>{var c;return[a("div",S,_((c=y.value)==null?void 0:c.name),1)]}),_:1},8,["options"]),r(s(E),{options:v.value},null,8,["options"])]}),_:1},8,["api-key","center"]))}};export{R as _};
