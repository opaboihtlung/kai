import{r as Q,L as k,o as c,c as m,w as s,g as i,a as e,b as w,Q as x,k as y,e as q,f as B,F as $,h as f,i as h,t as p,d as C,O as D}from"./app-CD2aFJMz.js";import{_ as V,u as I,Q as L,a as N,b as _,c as g}from"./MainLayout-BhDzJCbe.js";import{Q as S}from"./QChip-BKFdpbUD.js";import{Q as Y}from"./QLayout-BZLnjnEC.js";import{d as j}from"./date-BNbFJ6l6.js";import"./selection-BtuRkBgR.js";import"./FooterComponent-yubzXBYP.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";import"./use-quasar-B6weMyZ6.js";const M={class:"flex justify-between items-center"},O=i("div",{class:"text-title"}," Notifications ",-1),T={class:"flex q-gutter-sm"},F={class:"flex q-gutter-sm items-center"},K={class:"flex q-gutter-sm"},X=Object.assign({layout:V},{__name:"List",props:["list"],setup(o){const b=I(),r=Q({search:""}),v=a=>{D.get(route("notification.list"),{search:r.search})},d=a=>j.formatDate(a,"D/M/YYYY hh:mm a");return k(()=>{b.setNotification(!1)}),(a,l)=>(c(),m(Y,{padding:"",class:"container"},{default:s(()=>[i("div",M,[O,i("div",T,[e(x,{modelValue:r.search,"onUpdate:modelValue":l[0]||(l[0]=n=>r.search=n),outlined:"","bg-color":"white",onKeyup:w(v,["enter"]),dense:"",placeholder:"Type here"},null,8,["modelValue"])])]),e(y,{class:"q-my-sm"}),e(L,null,{default:s(()=>{var n,u;return[(c(!0),q($,null,B(o.list.data,t=>(c(),m(N,{clickable:"",class:"q-mt-sm shadow-default bg-white q-pa-sm flex justify-between items-center",key:t.id,onClick:z=>a.$inertia.get(a.route("notification.show",t.id))},{default:s(()=>[e(_,null,{default:s(()=>[e(g,null,{default:s(()=>[h(p(t.title),1)]),_:2},1024),e(g,{caption:""},{default:s(()=>[h(p(d(t.created_at)),1)]),_:2},1024)]),_:2},1024),e(_,{side:""},{default:s(()=>[i("div",F,[e(S,{square:"",label:d(t==null?void 0:t.schedule_at)},null,8,["label"]),e(C,{size:"18px",name:"chevron_right"})])]),_:2},1024)]),_:2},1032,["onClick"]))),128)),i("div",K,[e(f,{onClick:l[1]||(l[1]=t=>a.$inertia.get(o.list.prev_page_url)),disable:!((n=o.list)!=null&&n.prev_page_url),round:"",flat:"",icon:"o_chevron_left"},null,8,["disable"]),e(f,{onClick:l[2]||(l[2]=t=>a.$inertia.get(o.list.next_page_url)),disable:!((u=o.list)!=null&&u.next_page_url),round:"",flat:"",icon:"o_chevron_right"},null,8,["disable"])])]}),_:1})]),_:1}))}});export{X as default};
