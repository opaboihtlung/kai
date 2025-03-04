import{Q}from"./QTab-jtlECmSj.js";import{Q as B}from"./QSpace-BqO1vlbS.js";import{r as O,o as s,c as u,w as t,a,Q as I,b as F,d as E,e as w,f as x,F as C,g as o,h as j,O as b,i as p,t as h,m,n as S,p as R}from"./app-CD2aFJMz.js";import{Q as T}from"./QTabs-DripzImO.js";import{_ as K,Q as V,a as y,b as f,c as v,d as P}from"./MainLayout-BhDzJCbe.js";import{Q as g}from"./QChip-BKFdpbUD.js";import{Q as U}from"./QLayout-BZLnjnEC.js";import{C as q}from"./ClosePopup-BBeWmOkr.js";import{u as Y}from"./use-quasar-B6weMyZ6.js";import"./rtl-DFPa-2ov.js";import"./selection-BtuRkBgR.js";import"./FooterComponent-yubzXBYP.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const M=o("div",{class:"flex justify-between"},[o("div",null,[o("div",{class:"text-title"},"Appeal"),o("div",{class:"text-caption text-grey-7"},"List of Appeal Attendance.")]),o("div")],-1),z=o("br",null,null,-1),G={class:"flex q-gutter-sm"},H={class:"flex q-gutter-sm"},de=Object.assign({layout:K},{__name:"LateReasonList",props:["list","search"],setup(d){const k=d,i=Y(),_=O({search:k==null?void 0:k.search,tab:route().current(),selected:null}),L=n=>{i.dialog({title:"Confirmation",message:"Do you want to approved?",ok:"Yes",cancel:"No"}).onOk(()=>{b.post(route("appeal.approvelate2",n.id),{},{onStart:l=>i.loading.show(),onFinish:l=>i.loading.hide()})})},A=n=>{i.dialog({title:"Confirmation",message:"Do you want to rejected?",ok:"Yes",cancel:"No"}).onOk(()=>{b.post(route("appeal.rejectlate2",n.id),{},{onStart:l=>i.loading.show(),onFinish:l=>i.loading.hide()})})},D=n=>{b.get(route("appeal.late_reason"),{search:_.search})},N=n=>{b.get(route(n))};return(n,l)=>(s(),u(U,{class:"container",padding:""},{default:t(()=>[M,a(T,{class:"q-mt-sm",stretch:"",shrink:"",modelValue:_.tab,"onUpdate:modelValue":[l[1]||(l[1]=c=>_.tab=c),N],align:"start"},{default:t(()=>[a(Q,{name:"appeal.late_reason",label:"Late-Reason"}),a(Q,{name:"appeal.left_early",label:"Left-Early"}),a(Q,{name:"appeal.on_duty",label:"On-Duty"}),a(B),a(I,{modelValue:_.search,"onUpdate:modelValue":l[0]||(l[0]=c=>_.search=c),autofocus:"",outlined:"",dense:"",onKeyup:F(D,["enter"]),"bg-color":"white",placeholder:"Enter fullname"},{append:t(()=>[a(E,{name:"o_search"})]),_:1},8,["modelValue"])]),_:1},8,["modelValue"]),z,a(V,{separator:"",class:"bg-white shadow-default"},{default:t(()=>{var c;return[(s(!0),w(C,null,x((c=d.list)==null?void 0:c.data,(e,$)=>(s(),u(y,{key:$},{default:t(()=>[a(f,null,{default:t(()=>[a(v,null,{default:t(()=>{var r;return[p(h((r=e==null?void 0:e.user)==null?void 0:r.full_name),1)]}),_:2},1024),o("div",null,[(s(!0),w(C,null,x(e.user.offices,r=>(s(),u(g,{class:"text-caption q-ml-none q-mt-none",square:"",label:r==null?void 0:r.name},null,8,["label"]))),256))])]),_:2},1024),a(f,null,{default:t(()=>[p(h(e==null?void 0:e.reason),1)]),_:2},1024),a(g,{square:""},{default:t(()=>[a(f,null,{default:t(()=>[p("Date: ("+h(e==null?void 0:e.start_date)+") ",1),a(v,{caption:"",style:{color:"black"}},{default:t(()=>[p(" Signin: "+h(e==null?void 0:e.signin_time),1)]),_:2},1024)]),_:2},1024)]),_:2},1024),a(f,{side:""},{default:t(()=>[o("div",G,[o("div",null,[e.status==="Approved"?(s(),u(g,{key:0,"text-color":"white",color:"positive",label:"Approved"})):m("",!0),e.status==="Rejected"?(s(),u(g,{key:1,"text-color":"white",color:"negative",label:"Rejected"})):m("",!0),e.status==="Submitted"?(s(),u(g,{key:2,"text-color":"white",color:"blue",label:"Submitted"})):m("",!0)])])]),_:2},1024),a(P,{class:"q-pa-xs","dropdown-icon":"more_vert",right:""},{default:t(()=>[a(V,null,{default:t(()=>[e.status==="Submitted"||e.status==="Rejected"?S((s(),u(y,{key:0,clickable:"",onClick:R(r=>L(e,"approve"),["stop"])},{default:t(()=>[a(f,{side:""},{default:t(()=>[a(v,null,{default:t(()=>[p("Approve")]),_:1})]),_:1})]),_:2},1032,["onClick"])),[[q]]):m("",!0),e.status==="Submitted"||e.status==="Rejected"?S((s(),u(y,{key:1,clickable:"",onClick:R(r=>A(e,"reject"),["stop"])},{default:t(()=>[a(f,{side:""},{default:t(()=>[a(v,null,{default:t(()=>[p("Reject")]),_:1})]),_:1})]),_:2},1032,["onClick"])),[[q]]):m("",!0)]),_:2},1024)]),_:2},1024)]),_:2},1024))),128)),o("div",H,[a(j,{disable:!d.list.prev_page_url,onClick:l[2]||(l[2]=e=>n.$inertia.get(d.list.prev_page_url)),flat:"",round:"",icon:"o_chevron_left"},null,8,["disable"]),a(j,{disable:!d.list.next_page_url,onClick:l[3]||(l[3]=e=>n.$inertia.get(d.list.next_page_url)),flat:"",round:"",icon:"o_chevron_right"},null,8,["disable"])])]}),_:1})]),_:1}))}});export{de as default};
