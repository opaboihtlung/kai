import{ag as Q,ao as h,ap as $,H as L,j as g,A as c,M,L as j,n as A,aq as W,E as r,a1 as k,ar as N,as as E,d as P,W as F,at as O,au as H,D as U}from"./app-CD2aFJMz.js";let z=0;const G=["click","keydown"],J={icon:String,label:[Number,String],alert:[Boolean,String],alertIcon:String,name:{type:[Number,String],default:()=>`t_${z++}`},noCaps:Boolean,tabindex:[String,Number],disable:Boolean,contentClass:String,ripple:{type:[Boolean,Object],default:!0}};function V(e,b,s,n){const a=Q($,h);if(a===h)return console.error("QTab/QRouteTab component needs to be child of QTabs"),h;const{proxy:T}=L(),v=g(null),m=g(null),C=g(null),_=c(()=>e.disable===!0||e.ripple===!1?!1:Object.assign({keyCodes:[13,32],early:!0},e.ripple===!0?{}:e.ripple)),f=c(()=>a.currentModel.value===e.name),R=c(()=>"q-tab relative-position self-stretch flex flex-center text-center"+(f.value===!0?" q-tab--active"+(a.tabProps.value.activeClass?" "+a.tabProps.value.activeClass:"")+(a.tabProps.value.activeColor?` text-${a.tabProps.value.activeColor}`:"")+(a.tabProps.value.activeBgColor?` bg-${a.tabProps.value.activeBgColor}`:""):" q-tab--inactive")+(e.icon&&e.label&&a.tabProps.value.inlineLabel===!1?" q-tab--full":"")+(e.noCaps===!0||a.tabProps.value.noCaps===!0?" q-tab--no-caps":"")+(e.disable===!0?" disabled":" q-focusable q-hoverable cursor-pointer")+(n!==void 0?n.linkClass.value:"")),x=c(()=>"q-tab__content self-stretch flex-center relative-position q-anchor--skip non-selectable "+(a.tabProps.value.inlineLabel===!0?"row no-wrap q-tab__content--inline":"column")+(e.contentClass!==void 0?` ${e.contentClass}`:"")),I=c(()=>e.disable===!0||a.hasFocus.value===!0||f.value===!1&&a.hasActiveTab.value===!0?-1:e.tabindex||0);function q(t,l){if(l!==!0&&v.value!==null&&v.value.focus(),e.disable===!0){n!==void 0&&n.hasRouterLink.value===!0&&k(t);return}if(n===void 0){a.updateModel({name:e.name}),s("click",t);return}if(n.hasRouterLink.value===!0){const i=(o={})=>{let d;const K=o.to===void 0||O(o.to,e.to)===!0?a.avoidRouteWatcher=H():null;return n.navigateToRouterLink(t,{...o,returnRouterError:!0}).catch(u=>{d=u}).then(u=>{if(K===a.avoidRouteWatcher&&(a.avoidRouteWatcher=!1,d===void 0&&(u===void 0||u.message!==void 0&&u.message.startsWith("Avoided redundant navigation")===!0)&&a.updateModel({name:e.name})),o.returnRouterError===!0)return d!==void 0?Promise.reject(d):u})};s("click",t,i),t.defaultPrevented!==!0&&i();return}s("click",t)}function w(t){N(t,[13,32])?q(t,!0):E(t)!==!0&&t.keyCode>=35&&t.keyCode<=40&&t.altKey!==!0&&t.metaKey!==!0&&a.onKbdNavigate(t.keyCode,T.$el)===!0&&k(t),s("keydown",t)}function S(){const t=a.tabProps.value.narrowIndicator,l=[],i=r("div",{ref:C,class:["q-tab__indicator",a.tabProps.value.indicatorClass]});e.icon!==void 0&&l.push(r(P,{class:"q-tab__icon",name:e.icon})),e.label!==void 0&&l.push(r("div",{class:"q-tab__label"},e.label)),e.alert!==!1&&l.push(e.alertIcon!==void 0?r(P,{class:"q-tab__alert-icon",color:e.alert!==!0?e.alert:void 0,name:e.alertIcon}):r("div",{class:"q-tab__alert"+(e.alert!==!0?` text-${e.alert}`:"")})),t===!0&&l.push(i);const o=[r("div",{class:"q-focus-helper",tabindex:-1,ref:v}),r("div",{class:x.value},F(b.default,l))];return t===!1&&o.push(i),o}const y={name:c(()=>e.name),rootRef:m,tabIndicatorRef:C,routeData:n};M(()=>{a.unregisterTab(y)}),j(()=>{a.registerTab(y)});function B(t,l){const i={ref:m,class:R.value,tabindex:I.value,role:"tab","aria-selected":f.value===!0?"true":"false","aria-disabled":e.disable===!0?"true":void 0,onClick:q,onKeydown:w,...l};return A(r(t,i,S()),[[W,_.value]])}return{renderTab:B,$tabs:a}}const Y=U({name:"QTab",props:J,emits:G,setup(e,{slots:b,emit:s}){const{renderTab:n}=V(e,b,s);return()=>n("div")}});export{Y as Q};
