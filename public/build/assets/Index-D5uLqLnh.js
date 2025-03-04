import{Q as y}from"./QSelect-DAcR8xz5.js";import{r as k,T as V,L as q,o as d,c as f,w as a,g as s,a as t,u as i,Q as _,h as u,e as C,f as I,F as $,d as g,i as b,t as v}from"./app-CD2aFJMz.js";import{Q as B}from"./QForm-BBfP4Z3U.js";import{_ as R,Q as S,a as F,b as m,c as D}from"./MainLayout-BhDzJCbe.js";import{Q as L}from"./QLayout-BZLnjnEC.js";import{d as P}from"./date-BNbFJ6l6.js";import"./QChip-BKFdpbUD.js";import"./rtl-DFPa-2ov.js";import"./selection-BtuRkBgR.js";import"./FooterComponent-yubzXBYP.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";import"./use-quasar-B6weMyZ6.js";const Y=s("div",{class:"flex justify-between items-center"},[s("div",null,[s("div",{class:"text-title"},"Report")])],-1),j=s("br",null,null,-1),z={class:"row q-col-gutter-sm bg-white"},M={class:"col-xs-12 col-sm-7"},N={class:"bg-white q-pa-md"},U=s("div",{class:"text-lg text-grey-7 text-md"},"Filter",-1),E={class:"flex justify-end q-gutter-sm"},G={class:"col-xs-12 col-sm-5"},O={class:"column q-pa-md"},T=s("div",{class:"text-lg text-grey-7 text-md"},"Reports",-1),A={class:"flex q-gutter-sm"},ne=Object.assign({layout:R},{__name:"Index",props:["toDate","fromDate","offices","reports"],setup(n){const c=n,p=k({offices:[],users:[]}),l=V({office:null,user:null,fromDate:c.fromDate,toDate:c.toDate}),x=r=>P.formatDate(r,"DD-MM-YYYY hh:mm a"),h=r=>{l.office=null,l.user=null,l.fromDate=c.fromDate,l.toDate=null},Q=r=>{window.open(r,"_blank")},w=r=>{l.transform(o=>{var e;return{office_id:o.office.value,user_id:(e=o.user)==null?void 0:e.value,...o}}).post(route("report.generate"),{preserveState:!1})};return q(()=>{p.offices=c.offices}),(r,o)=>(d(),f(L,{class:"container",padding:""},{default:a(()=>[Y,j,s("div",z,[s("div",M,[s("div",N,[t(B,{onSubmit:w,class:"column q-gutter-sm"},{default:a(()=>[U,t(y,{modelValue:i(l).office,"onUpdate:modelValue":o[0]||(o[0]=e=>i(l).office=e),options:p.offices,outlined:"","bg-color":"white",label:"Office",rules:[e=>!!e||"Please select office"]},null,8,["modelValue","options","rules"]),t(_,{modelValue:i(l).fromDate,"onUpdate:modelValue":o[1]||(o[1]=e=>i(l).fromDate=e),type:"date",outlined:"",label:"Report starting from","bg-color":"white",rules:[e=>!!e||""]},null,8,["modelValue","rules"]),t(_,{modelValue:i(l).toDate,"onUpdate:modelValue":o[2]||(o[2]=e=>i(l).toDate=e),type:"date",outlined:"",label:"Report Ends to","bg-color":"white"},null,8,["modelValue"]),s("div",E,[t(u,{type:"submit",color:"primary",label:"Generate"}),t(u,{onClick:h,color:"negative",outline:"",label:"Reset"})])]),_:1})])]),s("div",G,[s("div",O,[T,t(S,{separator:""},{default:a(()=>[(d(!0),C($,null,I(n.reports.data,e=>(d(),f(F,{key:e.id},{default:a(()=>[t(m,{avatar:""},{default:a(()=>[e.status==="Processed"?(d(),f(g,{key:0,size:"sm",color:"positive",name:"fiber_manual_record"})):(d(),f(g,{key:1,size:"sm",color:"warning",name:"fiber_manual_record"}))]),_:2},1024),t(m,null,{default:a(()=>[t(D,null,{default:a(()=>[b(v(e==null?void 0:e.title),1)]),_:2},1024),t(D,{caption:""},{default:a(()=>[b("Generated At : "+v(x(e==null?void 0:e.created_at)),1)]),_:2},1024)]),_:2},1024),t(m,{side:""},{default:a(()=>[t(u,{disable:e.status!=="Processed",onClick:H=>Q(e.path),icon:"download",outline:"",size:"sm",round:""},null,8,["disable","onClick"])]),_:2},1024)]),_:2},1024))),128)),s("div",A,[t(u,{disable:!n.reports.prev_page_url,onClick:o[3]||(o[3]=e=>r.$inertia.get(n.reports.prev_page_url)),flat:"",round:"",icon:"o_chevron_left"},null,8,["disable"]),t(u,{disable:!n.reports.next_page_url,onClick:o[4]||(o[4]=e=>r.$inertia.get(n.reports.next_page_url)),flat:"",round:"",icon:"o_chevron_right"},null,8,["disable"])])]),_:1})])])])]),_:1}))}});export{ne as default};
