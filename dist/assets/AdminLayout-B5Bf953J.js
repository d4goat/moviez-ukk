import{h as E,K as t1,c as Y,_ as h1,m as R,p as u,A as f,L as $,x as s,H as Z,y as S,v as O,C as B,M as W,B as A,N as g1,o as m1,e as w,O as b1,P as s1,j as L,b as w1,w as n1,Q as _1,R as v1,U as o1,k as r1,V as y1,q as Q,z as x,W as a1,I as l1,J as i1,X as x1,l as k1,Y as X}from"./main-B8dzZHEF.js";const S1=E({name:"layout-page-title",components:{},setup(){const e=t1(),n=Y(()=>e.meta.pageTitle),t=Y(()=>e.meta.breadcrumbs);return{pageTitle:n,breadcrumb:t}}}),L1={class:"flex flex-col justify-center mr-3 flex-wrap"},M1={class:"flex text-gray-500 font-medium text-xl flex-col justify-center my-0"},H1={key:0,class:"breadcrumb breadcrumb-separatorless fw-semibold text-sm my-0 pt-2"},V1={class:"breadcrumb-item"};function $1(e,n,t,o,l,C){const h=R("router-link");return u(),f("div",L1,[e.pageTitle?(u(),f($,{key:0},[s("h1",M1,Z(e.pageTitle),1),e.breadcrumb?(u(),f("ul",H1,[s("li",V1,[S(h,{to:"/",class:"text-hover-primary"},{default:O(()=>[B("Dashboard")]),_:1})]),(u(!0),f($,null,W(e.breadcrumb,(p,b)=>(u(),f("li",{key:b,class:"breadcrumb-item"},Z(p),1))),128))])):A("",!0)],64)):A("",!0)])}const A1=h1(S1,[["render",$1]]);function O1(e){return g1()?(m1(e),!0):!1}function U(e){return typeof e=="function"?e():w(e)}const d1=typeof window<"u"&&typeof document<"u";typeof WorkerGlobalScope<"u"&&globalThis instanceof WorkerGlobalScope;const Z1=Object.prototype.toString,B1=e=>Z1.call(e)==="[object Object]",z=()=>{},E1=T1();function T1(){var e,n;return d1&&((e=window?.navigator)==null?void 0:e.userAgent)&&(/iP(?:ad|hone|od)/.test(window.navigator.userAgent)||((n=window?.navigator)==null?void 0:n.maxTouchPoints)>2&&/iPad|Macintosh/.test(window?.navigator.userAgent))}function D1(e,n){function t(...o){return new Promise((l,C)=>{Promise.resolve(e(()=>n.apply(this,o),{fn:n,thisArg:this,args:o})).then(l).catch(C)})}return t}const u1=e=>e();function N1(e=u1){const n=L(!0);function t(){n.value=!1}function o(){n.value=!0}const l=(...C)=>{n.value&&e(...C)};return{isActive:w1(n),pause:t,resume:o,eventFilter:l}}function P1(e){return _1()}function j1(e,n,t={}){const{eventFilter:o=u1,...l}=t;return n1(e,D1(o,n),l)}function F1(e,n,t={}){const{eventFilter:o,...l}=t,{eventFilter:C,pause:h,resume:p,isActive:b}=N1(o);return{stop:j1(e,n,{...l,eventFilter:C}),pause:h,resume:p,isActive:b}}function W1(e,n=!0,t){P1()?b1(e,t):n?e():s1(e)}const J=d1?window:void 0;function T(e){var n;const t=U(e);return(n=t?.$el)!=null?n:t}function D(...e){let n,t,o,l;if(typeof e[0]=="string"||Array.isArray(e[0])?([t,o,l]=e,n=J):[n,t,o,l]=e,!n)return z;Array.isArray(t)||(t=[t]),Array.isArray(o)||(o=[o]);const C=[],h=()=>{C.forEach(v=>v()),C.length=0},p=(v,g,i,r)=>(v.addEventListener(g,i,r),()=>v.removeEventListener(g,i,r)),b=n1(()=>[T(n),U(l)],([v,g])=>{if(h(),!v)return;const i=B1(g)?{...g}:g;C.push(...t.flatMap(r=>o.map(c=>p(v,r,c,i))))},{immediate:!0,flush:"post"}),_=()=>{b(),h()};return O1(_),_}let I=!1;function c1(e,n,t={}){const{window:o=J,ignore:l=[],capture:C=!0,detectIframe:h=!1}=t;if(!o)return z;E1&&!I&&(I=!0,Array.from(o.document.body.children).forEach(r=>r.addEventListener("click",z)),o.document.documentElement.addEventListener("click",z));let p=!0;const b=r=>U(l).some(c=>{if(typeof c=="string")return Array.from(o.document.querySelectorAll(c)).some(d=>d===r.target||r.composedPath().includes(d));{const d=T(c);return d&&(r.target===d||r.composedPath().includes(d))}}),_=r=>{const c=T(e);if(!(!c||c===r.target||r.composedPath().includes(c))){if(r.detail===0&&(p=!b(r)),!p){p=!0;return}n(r)}};let v=!1;const g=[D(o,"click",r=>{v||(v=!0,setTimeout(()=>{v=!1},0),_(r))},{passive:!0,capture:C}),D(o,"pointerdown",r=>{const c=T(e);p=!b(r)&&!!(c&&!r.composedPath().includes(c))},{passive:!0}),h&&D(o,"blur",r=>{setTimeout(()=>{var c;const d=T(e);((c=o.document.activeElement)==null?void 0:c.tagName)==="IFRAME"&&!d?.contains(o.document.activeElement)&&n(r)},0)})].filter(Boolean);return()=>g.forEach(r=>r())}const j=typeof globalThis<"u"?globalThis:typeof window<"u"?window:typeof global<"u"?global:typeof self<"u"?self:{},F="__vueuse_ssr_handlers__",z1=J1();function J1(){return F in j||(j[F]=j[F]||{}),j[F]}function R1(e,n){return z1[e]||n}function U1(e){return e==null?"any":e instanceof Set?"set":e instanceof Map?"map":e instanceof Date?"date":typeof e=="boolean"?"boolean":typeof e=="string"?"string":typeof e=="object"?"object":Number.isNaN(e)?"any":"number"}const G1={boolean:{read:e=>e==="true",write:e=>String(e)},object:{read:e=>JSON.parse(e),write:e=>JSON.stringify(e)},number:{read:e=>Number.parseFloat(e),write:e=>String(e)},any:{read:e=>e,write:e=>String(e)},string:{read:e=>e,write:e=>String(e)},map:{read:e=>new Map(JSON.parse(e)),write:e=>JSON.stringify(Array.from(e.entries()))},set:{read:e=>new Set(JSON.parse(e)),write:e=>JSON.stringify(Array.from(e))},date:{read:e=>new Date(e),write:e=>e.toISOString()}},e1="vueuse-storage";function G(e,n,t,o={}){var l;const{flush:C="pre",deep:h=!0,listenToStorageChanges:p=!0,writeDefaults:b=!0,mergeDefaults:_=!1,shallow:v,window:g=J,eventFilter:i,onError:r=a=>{console.error(a)},initOnMounted:c}=o,d=(v?v1:L)(typeof n=="function"?n():n);if(!t)try{t=R1("getDefaultStorage",()=>{var a;return(a=J)==null?void 0:a.localStorage})()}catch(a){r(a)}if(!t)return d;const M=U(n),m=U1(M),V=(l=o.serializer)!=null?l:G1[m],{pause:H,resume:N}=F1(d,()=>f1(d.value),{flush:C,deep:h,eventFilter:i});g&&p&&W1(()=>{t instanceof Storage?D(g,"storage",P):D(g,e1,C1),c&&P()}),c||P();function q(a,y){if(g){const k={key:e,oldValue:a,newValue:y,storageArea:t};g.dispatchEvent(t instanceof Storage?new StorageEvent("storage",k):new CustomEvent(e1,{detail:k}))}}function f1(a){try{const y=t.getItem(e);if(a==null)q(y,null),t.removeItem(e);else{const k=V.write(a);y!==k&&(t.setItem(e,k),q(y,k))}}catch(y){r(y)}}function p1(a){const y=a?a.newValue:t.getItem(e);if(y==null)return b&&M!=null&&t.setItem(e,V.write(M)),M;if(!a&&_){const k=V.read(y);return typeof _=="function"?_(k,M):m==="object"&&!Array.isArray(k)?{...M,...k}:k}else return typeof y!="string"?y:V.read(y)}function P(a){if(!(a&&a.storageArea!==t)){if(a&&a.key==null){d.value=M;return}if(!(a&&a.key!==e)){H();try{a?.newValue!==V.write(d.value)&&(d.value=p1(a))}catch(y){r(y)}finally{a?s1(N):N()}}}}function C1(a){P(a.detail)}return d}const K=o1("sidebar",()=>{const e=L(!1),n=G("selected",L("eCommerce")),t=G("page",L("Dashboard"));function o(){e.value=!e.value}return{isSidebarOpen:e,toggleSidebar:o,selected:n,page:t}}),K1=[{heading:"Admin",name:"dashboard",pages:[{heading:"Dashboard",route:"/admin/dashboard",name:"admin-dashboard"}]},{heading:"Website",name:"website",pages:[{sectionTitle:"Master",route:"/admin/dashboard/master",name:"master",sub:[{heading:"Cinema",name:"master-cinema",route:"/admin/dashboard/master/cinema"},{heading:"Film",name:"master-film",route:"/admin/dashboard/master/film"},{heading:"Genre",name:"master-genre",route:"/admin/dashboard/master/genre"},{heading:"Promotion",name:"master-promotion",route:"/admin/dashboard/master/promotion"},{heading:"Studio",name:"master-studio",route:"/admin/dashboard/master/studio"},{heading:"Users",name:"master-users",route:"/admin/dashboard/master/users"}]},{heading:"Booking",name:"booking",route:"/admin/dashboard/booking"},{heading:"Setting",name:"setting",route:"/admin/dashboard/setting"}]}],q1={class:"flex items-center justify-between gap-2 px-6 py-4 lg:py-6.5"},Y1=s("span",{class:"text-cinema text-3xl font-medium"},"Cinema51",-1),Q1=s("svg",{class:"fill-current text-gray",width:"20",height:"18",viewBox:"0 0 20 18",fill:"none",xmlns:"http://www.w3.org/2000/svg"},[s("path",{d:"M19 8.175H2.98748L9.36248 1.6875C9.69998 1.35 9.69998 0.825 9.36248 0.4875C9.02498 0.15 8.49998 0.15 8.16248 0.4875L0.399976 8.3625C0.0624756 8.7 0.0624756 9.225 0.399976 9.5625L8.16248 17.4375C8.31248 17.5875 8.53748 17.7 8.76248 17.7C8.98748 17.7 9.17498 17.625 9.36248 17.475C9.69998 17.1375 9.69998 16.6125 9.36248 16.275L3.02498 9.8625H19C19.45 9.8625 19.825 9.4875 19.825 9.0375C19.825 8.55 19.45 8.175 19 8.175Z",fill:""})],-1),X1=[Q1],I1={class:"no-scrollbar flex flex-col overflow-y-auto duration-300 ease-linear"},ee={class:"mt-2 pb-2 px-3 lg:mt-4 lg:px-6"},te={key:0},se={class:"mb-2 ml-4 text-sm font-medium text-bodydark2"},ne={class:"mb-3 flex flex-col gap-1.5"},oe={key:0},re={key:1},ae=["onClick"],le=s("path",{"fill-rule":"evenodd","clip-rule":"evenodd",d:"M4.41107 6.9107C4.73651 6.58527 5.26414 6.58527 5.58958 6.9107L10.0003 11.3214L14.4111 6.91071C14.7365 6.58527 15.2641 6.58527 15.5896 6.91071C15.915 7.23614 15.915 7.76378 15.5896 8.08922L10.5896 13.0892C10.2641 13.4147 9.73651 13.4147 9.41107 13.0892L4.41107 8.08922C4.08563 7.76378 4.08563 7.23614 4.41107 6.9107Z",fill:""},null,-1),ie=[le],de={class:"mt-2 pl-6"},ue={class:"mb-5.5 flex flex-col gap-2"},ce=E({__name:"SidebarMenu",setup(e){const{user:n}=r1(),t=L(null);t1();const o=L(new Set),{t:l,te:C}=y1.useI18n(),h=i=>C(i)?l(i):i,p=K();c1(t,()=>{p.isSidebarOpen=!1});const b=i=>i.startsWith(i.path),_=i=>!!n?.permission?.includes(i),v=i=>{o.value.has(i.route)?o.value.delete(i.route):o.value.add(i.route)},g=i=>o.value.has(i.route)||b(i.route);return(i,r)=>{const c=R("router-link");return u(),f("aside",{class:x(["absolute left-0 top-0 z-9999 flex h-screen w-60 flex-col overflow-y-hidden bg-sidebar border-r-2 border-gray-600 duration-300 ease-linear dark:bg-dark-bg lg:static lg:translate-x-0",{"translate-x-0":w(p).isSidebarOpen,"-translate-x-full":!w(p).isSidebarOpen}]),ref_key:"target",ref:t},[s("div",q1,[S(c,{to:"/",class:"mx-3"},{default:O(()=>[Y1]),_:1}),s("button",{class:"block lg:hidden",onClick:r[0]||(r[0]=d=>w(p).isSidebarOpen=!1)},X1)]),s("div",I1,[s("nav",ee,[(u(!0),f($,null,W(w(K1),(d,M)=>(u(),f($,{key:M},[d.heading&&_(d.name)?(u(),f("div",te,[s("h3",se,Z(h(d.heading)),1),s("ul",ne,[(u(!0),f($,null,W(d.pages,(m,V)=>(u(),f($,{key:V},[m.heading&&_(m.name)?(u(),f("li",oe,[m.route?(u(),Q(c,{key:0,to:m.route,class:x(["group relative flex items-center gap-2.5 rounded-lg py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4",{"bg-graydark dark:bg-meta-4":i.$route.path===m.route}])},{default:O(()=>[s("span",null,Z(h(m.heading)),1)]),_:2},1032,["to","class"])):A("",!0)])):A("",!0),m.sectionTitle&&m.route&&_(m.name)?(u(),f("li",re,[s("a",{href:"#",class:x(["group relative flex items-center gap-2.5 rounded-lg py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4",{"bg-graydark dark:bg-meta-4":g(m)}]),onClick:a1(H=>v(m),["prevent"])},[s("span",null,Z(h(m.sectionTitle)),1),(u(),f("svg",{class:x(["absolute right-4 top-1/2 -translate-y-1/2 fill-current",{"rotate-180":g(m)}]),width:"20",height:"20",viewBox:"0 0 20 20",fill:"none",xmlns:"http://www.w3.org/2000/svg"},ie,2))],10,ae),l1(s("div",de,[s("ul",ue,[(u(!0),f($,null,W(m.sub,(H,N)=>(u(),f("li",{key:N},[H.route&&_(H.name)?(u(),Q(c,{key:0,to:H.route,class:x(["group relative flex items-center gap-2.5 rounded-md px-2 font-medium text-bodydark2 duration-300 ease-in-out hover:text-white",{"text-white":i.$route.path===H.route}])},{default:O(()=>[B(Z(h(H.heading||H.sectionTitle)),1)]),_:2},1032,["to","class"])):A("",!0)]))),128))])],512),[[i1,g(m)]])])):A("",!0)],64))),128))])])):A("",!0)],64))),128))])])],2)}}}),fe=o1("darkMode",()=>{const e=G("darkMode",L(!1));document.documentElement.classList.toggle("dark",e.value);function n(){e.value=!e.value,document.documentElement.classList.toggle("dark",e.value)}return{darkMode:e,toggleDarkMode:n}}),pe=s("input",{type:"checkbox",class:"absolute top-0 z-50 m-0 h-full w-full cursor-pointer opacity-0"},null,-1),Ce=x1('<span class="dark:hidden"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.99992 12.6666C10.5772 12.6666 12.6666 10.5772 12.6666 7.99992C12.6666 5.42259 10.5772 3.33325 7.99992 3.33325C5.42259 3.33325 3.33325 5.42259 3.33325 7.99992C3.33325 10.5772 5.42259 12.6666 7.99992 12.6666Z" fill="#969AA1"></path><path d="M8.00008 15.3067C7.63341 15.3067 7.33342 15.0334 7.33342 14.6667V14.6134C7.33342 14.2467 7.63341 13.9467 8.00008 13.9467C8.36675 13.9467 8.66675 14.2467 8.66675 14.6134C8.66675 14.9801 8.36675 15.3067 8.00008 15.3067ZM12.7601 13.4267C12.5867 13.4267 12.4201 13.3601 12.2867 13.2334L12.2001 13.1467C11.9401 12.8867 11.9401 12.4667 12.2001 12.2067C12.4601 11.9467 12.8801 11.9467 13.1401 12.2067L13.2267 12.2934C13.4867 12.5534 13.4867 12.9734 13.2267 13.2334C13.1001 13.3601 12.9334 13.4267 12.7601 13.4267ZM3.24008 13.4267C3.06675 13.4267 2.90008 13.3601 2.76675 13.2334C2.50675 12.9734 2.50675 12.5534 2.76675 12.2934L2.85342 12.2067C3.11342 11.9467 3.53341 11.9467 3.79341 12.2067C4.05341 12.4667 4.05341 12.8867 3.79341 13.1467L3.70675 13.2334C3.58008 13.3601 3.40675 13.4267 3.24008 13.4267ZM14.6667 8.66675H14.6134C14.2467 8.66675 13.9467 8.36675 13.9467 8.00008C13.9467 7.63341 14.2467 7.33342 14.6134 7.33342C14.9801 7.33342 15.3067 7.63341 15.3067 8.00008C15.3067 8.36675 15.0334 8.66675 14.6667 8.66675ZM1.38675 8.66675H1.33341C0.966748 8.66675 0.666748 8.36675 0.666748 8.00008C0.666748 7.63341 0.966748 7.33342 1.33341 7.33342C1.70008 7.33342 2.02675 7.63341 2.02675 8.00008C2.02675 8.36675 1.75341 8.66675 1.38675 8.66675ZM12.6734 3.99341C12.5001 3.99341 12.3334 3.92675 12.2001 3.80008C11.9401 3.54008 11.9401 3.12008 12.2001 2.86008L12.2867 2.77341C12.5467 2.51341 12.9667 2.51341 13.2267 2.77341C13.4867 3.03341 13.4867 3.45341 13.2267 3.71341L13.1401 3.80008C13.0134 3.92675 12.8467 3.99341 12.6734 3.99341ZM3.32675 3.99341C3.15341 3.99341 2.98675 3.92675 2.85342 3.80008L2.76675 3.70675C2.50675 3.44675 2.50675 3.02675 2.76675 2.76675C3.02675 2.50675 3.44675 2.50675 3.70675 2.76675L3.79341 2.85342C4.05341 3.11342 4.05341 3.53341 3.79341 3.79341C3.66675 3.92675 3.49341 3.99341 3.32675 3.99341ZM8.00008 2.02675C7.63341 2.02675 7.33342 1.75341 7.33342 1.38675V1.33341C7.33342 0.966748 7.63341 0.666748 8.00008 0.666748C8.36675 0.666748 8.66675 0.966748 8.66675 1.33341C8.66675 1.70008 8.36675 2.02675 8.00008 2.02675Z" fill="#969AA1"></path></svg></span><span class="hidden dark:inline-block"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.3533 10.62C14.2466 10.44 13.9466 10.16 13.1999 10.2933C12.7866 10.3667 12.3666 10.4 11.9466 10.38C10.3933 10.3133 8.98659 9.6 8.00659 8.5C7.13993 7.53333 6.60659 6.27333 6.59993 4.91333C6.59993 4.15333 6.74659 3.42 7.04659 2.72666C7.33993 2.05333 7.13326 1.7 6.98659 1.55333C6.83326 1.4 6.47326 1.18666 5.76659 1.48C3.03993 2.62666 1.35326 5.36 1.55326 8.28666C1.75326 11.04 3.68659 13.3933 6.24659 14.28C6.85993 14.4933 7.50659 14.62 8.17326 14.6467C8.27993 14.6533 8.38659 14.66 8.49326 14.66C10.7266 14.66 12.8199 13.6067 14.1399 11.8133C14.5866 11.1933 14.4666 10.8 14.3533 10.62Z" fill="#969AA1"></path></svg></span>',2),he=[Ce],ge=E({__name:"DarkModeSwitcher",setup(e){const n=fe();return(t,o)=>(u(),f("label",{class:x([{"bg-primary":w(n).darkMode,"bg-stroke":!w(n).darkMode},"relative m-0 block h-7.5 w-14 rounded-full"]),onClick:o[0]||(o[0]=(...l)=>w(n).toggleDarkMode&&w(n).toggleDarkMode(...l))},[pe,s("span",{class:x([{"right-1 translate-x-full":w(n).darkMode},"absolute top-1/2 left-1 flex h-6 w-6 -translate-y-1/2 translate-x-0 items-center justify-center rounded-full bg-white shadow-switcher duration-75 ease-linear"])},he,2)],2))}}),me=s("span",{class:"h-12 w-12 rounded-full"},[s("img",{src:"/images/user/user-01.png",alt:"User"})],-1),be=s("path",{"fill-rule":"evenodd","clip-rule":"evenodd",d:"M0.410765 0.910734C0.736202 0.585297 1.26384 0.585297 1.58928 0.910734L6.00002 5.32148L10.4108 0.910734C10.7362 0.585297 11.2638 0.585297 11.5893 0.910734C11.9147 1.23617 11.9147 1.76381 11.5893 2.08924L6.58928 7.08924C6.26384 7.41468 5.7362 7.41468 5.41077 7.08924L0.410765 2.08924C0.0853277 1.76381 0.0853277 1.23617 0.410765 0.910734Z",fill:""},null,-1),we=[be],_e={class:"absolute right-0 mt-4 flex w-62.5 flex-col rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark"},ve={class:"flex flex-col gap-5 border-b border-stroke px-6 py-7.5 dark:border-strokedark"},ye=s("svg",{class:"fill-current",width:"22",height:"22",viewBox:"0 0 22 22",fill:"none",xmlns:"http://www.w3.org/2000/svg"},[s("path",{d:"M11 9.62499C8.42188 9.62499 6.35938 7.59687 6.35938 5.12187C6.35938 2.64687 8.42188 0.618744 11 0.618744C13.5781 0.618744 15.6406 2.64687 15.6406 5.12187C15.6406 7.59687 13.5781 9.62499 11 9.62499ZM11 2.16562C9.28125 2.16562 7.90625 3.50624 7.90625 5.12187C7.90625 6.73749 9.28125 8.07812 11 8.07812C12.7188 8.07812 14.0938 6.73749 14.0938 5.12187C14.0938 3.50624 12.7188 2.16562 11 2.16562Z",fill:""}),s("path",{d:"M17.7719 21.4156H4.2281C3.5406 21.4156 2.9906 20.8656 2.9906 20.1781V17.0844C2.9906 13.7156 5.7406 10.9656 9.10935 10.9656H12.925C16.2937 10.9656 19.0437 13.7156 19.0437 17.0844V20.1781C19.0094 20.8312 18.4594 21.4156 17.7719 21.4156ZM4.53748 19.8687H17.4969V17.0844C17.4969 14.575 15.4344 12.5125 12.925 12.5125H9.07498C6.5656 12.5125 4.5031 14.575 4.5031 17.0844V19.8687H4.53748Z",fill:""})],-1),xe=s("svg",{class:"fill-current",width:"22",height:"22",viewBox:"0 0 22 22",fill:"none",xmlns:"http://www.w3.org/2000/svg"},[s("path",{d:"M17.6687 1.44374C17.1187 0.893744 16.4312 0.618744 15.675 0.618744H7.42498C6.25623 0.618744 5.25935 1.58124 5.25935 2.78437V4.12499H4.29685C3.88435 4.12499 3.50623 4.46874 3.50623 4.91562C3.50623 5.36249 3.84998 5.70624 4.29685 5.70624H5.25935V10.2781H4.29685C3.88435 10.2781 3.50623 10.6219 3.50623 11.0687C3.50623 11.4812 3.84998 11.8594 4.29685 11.8594H5.25935V16.4312H4.29685C3.88435 16.4312 3.50623 16.775 3.50623 17.2219C3.50623 17.6687 3.84998 18.0125 4.29685 18.0125H5.25935V19.25C5.25935 20.4187 6.22185 21.4156 7.42498 21.4156H15.675C17.2218 21.4156 18.4937 20.1437 18.5281 18.5969V3.47187C18.4937 2.68124 18.2187 1.95937 17.6687 1.44374ZM16.9469 18.5625C16.9469 19.2844 16.3625 19.8344 15.6406 19.8344H7.3906C7.04685 19.8344 6.77185 19.5594 6.77185 19.2156V17.875H8.6281C9.0406 17.875 9.41873 17.5312 9.41873 17.0844C9.41873 16.6375 9.07498 16.2937 8.6281 16.2937H6.77185V11.7906H8.6281C9.0406 11.7906 9.41873 11.4469 9.41873 11C9.41873 10.5875 9.07498 10.2094 8.6281 10.2094H6.77185V5.63749H8.6281C9.0406 5.63749 9.41873 5.29374 9.41873 4.84687C9.41873 4.39999 9.07498 4.05624 8.6281 4.05624H6.77185V2.74999C6.77185 2.40624 7.04685 2.13124 7.3906 2.13124H15.6406C15.9844 2.13124 16.2937 2.26874 16.5687 2.50937C16.8094 2.74999 16.9469 3.09374 16.9469 3.43749V18.5625Z",fill:""})],-1),ke=s("svg",{class:"fill-current",width:"22",height:"22",viewBox:"0 0 22 22",fill:"none",xmlns:"http://www.w3.org/2000/svg"},[s("path",{d:"M20.8656 8.86874C20.5219 8.49062 20.0406 8.28437 19.525 8.28437H19.4219C19.25 8.28437 19.1125 8.18124 19.0781 8.04374C19.0437 7.90624 18.975 7.80312 18.9406 7.66562C18.8719 7.52812 18.9406 7.39062 19.0437 7.28749L19.1125 7.21874C19.4906 6.87499 19.6969 6.39374 19.6969 5.87812C19.6969 5.36249 19.525 4.88124 19.1469 4.50312L17.8062 3.12812C17.0844 2.37187 15.8469 2.33749 15.0906 3.09374L14.9875 3.16249C14.8844 3.26562 14.7125 3.29999 14.5406 3.23124C14.4031 3.16249 14.2656 3.09374 14.0937 3.05937C13.9219 2.99062 13.8187 2.85312 13.8187 2.71562V2.54374C13.8187 1.47812 12.9594 0.618744 11.8937 0.618744H9.96875C9.45312 0.618744 8.97187 0.824994 8.62812 1.16874C8.25 1.54687 8.07812 2.02812 8.07812 2.50937V2.64687C8.07812 2.78437 7.975 2.92187 7.8375 2.99062C7.76875 3.02499 7.73437 3.02499 7.66562 3.05937C7.52812 3.12812 7.35625 3.09374 7.25312 2.99062L7.18437 2.88749C6.84062 2.50937 6.35937 2.30312 5.84375 2.30312C5.32812 2.30312 4.84687 2.47499 4.46875 2.85312L3.09375 4.19374C2.3375 4.91562 2.30312 6.15312 3.05937 6.90937L3.12812 7.01249C3.23125 7.11562 3.26562 7.28749 3.19687 7.39062C3.12812 7.52812 3.09375 7.63124 3.025 7.76874C2.95625 7.90624 2.85312 7.97499 2.68125 7.97499H2.57812C2.0625 7.97499 1.58125 8.14687 1.20312 8.52499C0.824996 8.86874 0.618746 9.34999 0.618746 9.86562L0.584371 11.7906C0.549996 12.8562 1.40937 13.7156 2.475 13.75H2.57812C2.75 13.75 2.8875 13.8531 2.92187 13.9906C2.99062 14.0937 3.05937 14.1969 3.09375 14.3344C3.12812 14.4719 3.09375 14.6094 2.99062 14.7125L2.92187 14.7812C2.54375 15.125 2.3375 15.6062 2.3375 16.1219C2.3375 16.6375 2.50937 17.1187 2.8875 17.4969L4.22812 18.8719C4.95 19.6281 6.1875 19.6625 6.94375 18.9062L7.04687 18.8375C7.15 18.7344 7.32187 18.7 7.49375 18.7687C7.63125 18.8375 7.76875 18.9062 7.94062 18.9406C8.1125 19.0094 8.21562 19.1469 8.21562 19.2844V19.4219C8.21562 20.4875 9.075 21.3469 10.1406 21.3469H12.0656C13.1312 21.3469 13.9906 20.4875 13.9906 19.4219V19.2844C13.9906 19.1469 14.0937 19.0094 14.2312 18.9406C14.3 18.9062 14.3344 18.9062 14.4031 18.8719C14.575 18.8031 14.7125 18.8375 14.8156 18.9406L14.8844 19.0437C15.2281 19.4219 15.7094 19.6281 16.225 19.6281C16.7406 19.6281 17.2219 19.4562 17.6 19.0781L18.975 17.7375C19.7312 17.0156 19.7656 15.7781 19.0094 15.0219L18.9406 14.9187C18.8375 14.8156 18.8031 14.6437 18.8719 14.5406C18.9406 14.4031 18.975 14.3 19.0437 14.1625C19.1125 14.025 19.25 13.9562 19.3875 13.9562H19.4906H19.525C20.5562 13.9562 21.4156 13.1312 21.45 12.0656L21.4844 10.1406C21.4156 9.72812 21.2094 9.21249 20.8656 8.86874ZM19.8344 12.1C19.8344 12.3062 19.6625 12.4781 19.4562 12.4781H19.3531H19.3187C18.5281 12.4781 17.8062 12.9594 17.5312 13.6469C17.4969 13.75 17.4281 13.8531 17.3937 13.9562C17.0844 14.6437 17.2219 15.5031 17.7719 16.0531L17.8406 16.1562C17.9781 16.2937 17.9781 16.5344 17.8406 16.6719L16.4656 18.0125C16.3625 18.1156 16.2594 18.1156 16.1906 18.1156C16.1219 18.1156 16.0187 18.1156 15.9156 18.0125L15.8469 17.9094C15.2969 17.325 14.4719 17.1531 13.7156 17.4969L13.5781 17.5656C12.8219 17.875 12.3406 18.5625 12.3406 19.3531V19.4906C12.3406 19.6969 12.1687 19.8687 11.9625 19.8687H10.0375C9.83125 19.8687 9.65937 19.6969 9.65937 19.4906V19.3531C9.65937 18.5625 9.17812 17.8406 8.42187 17.5656C8.31875 17.5312 8.18125 17.4625 8.07812 17.4281C7.80312 17.2906 7.52812 17.2562 7.25312 17.2562C6.77187 17.2562 6.29062 17.4281 5.9125 17.8062L5.84375 17.8406C5.70625 17.9781 5.46562 17.9781 5.32812 17.8406L3.9875 16.4656C3.88437 16.3625 3.88437 16.2594 3.88437 16.1906C3.88437 16.1219 3.88437 16.0187 3.9875 15.9156L4.05625 15.8469C4.64062 15.2969 4.8125 14.4375 4.50312 13.75C4.46875 13.6469 4.43437 13.5437 4.36562 13.4406C4.09062 12.7187 3.40312 12.2031 2.6125 12.2031H2.50937C2.30312 12.2031 2.13125 12.0312 2.13125 11.825L2.16562 9.89999C2.16562 9.76249 2.23437 9.69374 2.26875 9.62499C2.30312 9.59062 2.40625 9.52187 2.54375 9.52187H2.64687C3.4375 9.55624 4.15937 9.07499 4.46875 8.35312C4.50312 8.24999 4.57187 8.14687 4.60625 8.04374C4.91562 7.35624 4.77812 6.49687 4.22812 5.94687L4.15937 5.84374C4.02187 5.70624 4.02187 5.46562 4.15937 5.32812L5.53437 3.98749C5.6375 3.88437 5.74062 3.88437 5.80937 3.88437C5.87812 3.88437 5.98125 3.88437 6.08437 3.98749L6.15312 4.09062C6.70312 4.67499 7.52812 4.84687 8.28437 4.53749L8.42187 4.46874C9.17812 4.15937 9.65937 3.47187 9.65937 2.68124V2.54374C9.65937 2.40624 9.72812 2.33749 9.7625 2.26874C9.79687 2.19999 9.9 2.16562 10.0375 2.16562H11.9625C12.1687 2.16562 12.3406 2.33749 12.3406 2.54374V2.68124C12.3406 3.47187 12.8219 4.19374 13.5781 4.46874C13.6812 4.50312 13.8187 4.57187 13.9219 4.60624C14.6437 4.94999 15.5031 4.81249 16.0875 4.26249L16.1906 4.19374C16.3281 4.05624 16.5687 4.05624 16.7062 4.19374L18.0469 5.56874C18.15 5.67187 18.15 5.77499 18.15 5.84374C18.15 5.91249 18.1156 6.01562 18.0469 6.11874L17.9781 6.18749C17.3594 6.70312 17.1875 7.56249 17.4625 8.24999C17.4969 8.35312 17.5312 8.45624 17.6 8.55937C17.875 9.28124 18.5625 9.79687 19.3531 9.79687H19.4562C19.5937 9.79687 19.6625 9.86562 19.7312 9.89999C19.8 9.93437 19.8344 10.0375 19.8344 10.175V12.1Z",fill:""}),s("path",{d:"M11 6.32498C8.42189 6.32498 6.32501 8.42186 6.32501 11C6.32501 13.5781 8.42189 15.675 11 15.675C13.5781 15.675 15.675 13.5781 15.675 11C15.675 8.42186 13.5781 6.32498 11 6.32498ZM11 14.1281C9.28126 14.1281 7.87189 12.7187 7.87189 11C7.87189 9.28123 9.28126 7.87186 11 7.87186C12.7188 7.87186 14.1281 9.28123 14.1281 11C14.1281 12.7187 12.7188 14.1281 11 14.1281Z",fill:""})],-1),Se=s("svg",{class:"fill-current",width:"22",height:"22",viewBox:"0 0 22 22",fill:"none",xmlns:"http://www.w3.org/2000/svg"},[s("path",{d:"M15.5375 0.618744H11.6531C10.7594 0.618744 10.0031 1.37499 10.0031 2.26874V4.64062C10.0031 5.05312 10.3469 5.39687 10.7594 5.39687C11.1719 5.39687 11.55 5.05312 11.55 4.64062V2.23437C11.55 2.16562 11.5844 2.13124 11.6531 2.13124H15.5375C16.3625 2.13124 17.0156 2.78437 17.0156 3.60937V18.3562C17.0156 19.1812 16.3625 19.8344 15.5375 19.8344H11.6531C11.5844 19.8344 11.55 19.8 11.55 19.7312V17.3594C11.55 16.9469 11.2062 16.6031 10.7594 16.6031C10.3125 16.6031 10.0031 16.9469 10.0031 17.3594V19.7312C10.0031 20.625 10.7594 21.3812 11.6531 21.3812H15.5375C17.2219 21.3812 18.5625 20.0062 18.5625 18.3562V3.64374C18.5625 1.95937 17.1875 0.618744 15.5375 0.618744Z",fill:""}),s("path",{d:"M6.05001 11.7563H12.2031C12.6156 11.7563 12.9594 11.4125 12.9594 11C12.9594 10.5875 12.6156 10.2438 12.2031 10.2438H6.08439L8.21564 8.07813C8.52501 7.76875 8.52501 7.2875 8.21564 6.97812C7.90626 6.66875 7.42501 6.66875 7.11564 6.97812L3.67814 10.4844C3.36876 10.7938 3.36876 11.275 3.67814 11.5844L7.11564 15.0906C7.25314 15.2281 7.45939 15.3312 7.66564 15.3312C7.87189 15.3312 8.04376 15.2625 8.21564 15.125C8.52501 14.8156 8.52501 14.3344 8.21564 14.025L6.05001 11.7563Z",fill:""})],-1),Le=E({__name:"DropdownUser",setup(e){const n=L(null),t=L(!1),o=r1(),l=k1();c1(n,()=>{t.value=!1});const C=()=>{X.fire({icon:"warning",text:"Apakah Anda yakin ingin keluar?",showCancelButton:!0,confirmButtonText:"Ya, Keluar",cancelButtonText:"Batal",reverseButtons:!0,buttonsStyling:!1,customClass:{confirmButton:"btn font-medium btn-primary",cancelButton:"btn font-medium bg-red-600 hover:bg-red-700"}}).then(h=>{h.isConfirmed&&(o.logout(),X.fire({icon:"success",text:"Berhasil keluar"}).then(()=>{l.push({name:"sign-in"})}))})};return(h,p)=>{const b=R("router-link");return u(),f("div",{class:"relative",ref_key:"target",ref:n},[s("button",{class:"flex items-center gap-4",onClick:p[0]||(p[0]=a1(_=>t.value=!t.value,["prevent"])),type:"button"},[me,(u(),f("svg",{class:x([t.value&&"rotate-180","hidden fill-current sm:block"]),width:"12",height:"8",viewBox:"0 0 12 8",fill:"none",xmlns:"http://www.w3.org/2000/svg"},we,2))]),l1(s("div",_e,[s("ul",ve,[s("li",null,[S(b,{to:"/profile",class:"flex items-center gap-3.5 text-sm font-medium duration-300 ease-in-out hover:text-primary lg:text-base"},{default:O(()=>[ye,B(" My Profile ")]),_:1})]),s("li",null,[S(b,{to:"#",class:"flex items-center gap-3.5 text-sm font-medium duration-300 ease-in-out hover:text-primary lg:text-base"},{default:O(()=>[xe,B(" My Contacts ")]),_:1})]),s("li",null,[S(b,{to:"/pages/settings",class:"flex items-center gap-3.5 text-sm font-medium duration-300 ease-in-out hover:text-primary lg:text-base"},{default:O(()=>[ke,B(" Account Settings ")]),_:1})])]),s("button",{class:"flex items-center gap-3.5 py-4 px-6 text-sm font-medium duration-300 ease-in-out hover:text-primary lg:text-base",onClick:C},[Se,B(" Log Out ")])],512),[[i1,t.value]])],512)}}}),Me={class:"sticky top-0 z-999 flex w-full bg-meta-2 drop-shadow-1 border-b-[1px] border-gray-600 dark:bg-sidebar dark:drop-shadow-none"},He={class:"flex flex-grow items-center py-3 px-4 shadow-2 md:px-6 2xl:px-11"},Ve={class:"flex items-center gap-2 sm:gap-4 lg:hidden"},$e={class:"relative block h-5.5 w-5.5 cursor-pointer"},Ae={class:"block absolute right-0 h-full w-full"},Oe={class:"block absolute right-0 h-full w-full rotate-45"},Ze={class:"flex items-center gap-3 ml-auto 2xsm:gap-7"},Be={class:"flex items-center gap-2 2xsm:gap-4"},Ee=E({__name:"HeaderArea",setup(e){const{toggleSidebar:n}=K(),t=K();return(o,l)=>(u(),f("header",Me,[s("div",He,[s("div",Ve,[s("button",{class:"z-99999 block rounded-sm border border-stroke bg-white p-1.5 shadow-sm dark:border-strokedark dark:bg-sidebar lg:hidden",onClick:l[0]||(l[0]=()=>{console.log("Toggling Sidebar"),w(n)()})},[s("span",$e,[s("span",Ae,[s("span",{class:x(["relative top-0 left-0 my-1 block h-0.5 w-0 rounded-sm bg-black delay-[0] duration-200 ease-in-out dark:bg-white",{"!w-full delay-300":!w(t).isSidebarOpen}])},null,2),s("span",{class:x(["relative top-0 left-0 my-1 block h-0.5 w-0 rounded-sm bg-black delay-150 duration-200 ease-in-out dark:bg-white",{"!w-full delay-400":!w(t).isSidebarOpen}])},null,2),s("span",{class:x(["relative top-0 left-0 my-1 block h-0.5 w-0 rounded-sm bg-black delay-200 duration-200 ease-in-out dark:bg-white",{"!w-full delay-500":!w(t).isSidebarOpen}])},null,2)]),s("span",Oe,[s("span",{class:x(["absolute left-2.5 top-0 block h-full w-0.5 rounded-sm bg-black delay-300 duration-200 ease-in-out dark:bg-white",{"!h-0 delay-[0]":!w(t).isSidebarOpen}])},null,2),s("span",{class:x(["delay-400 absolute left-0 top-2.5 block h-0.5 w-full rounded-sm bg-black duration-200 ease-in-out dark:bg-white",{"!h-0 delay-200":!w(t).isSidebarOpen}])},null,2)])])])]),s("div",Ze,[s("ul",Be,[s("li",null,[S(ge)])]),S(Le)])])]))}}),Te={class:"flex h-screen overflow-hidden bg-dark-bg"},De={class:"relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden"},Ne={class:"mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10 text-bodydark1"},je=E({__name:"AdminLayout",setup(e){return(n,t)=>{const o=R("router-view");return u(),f("div",Te,[S(ce),s("div",De,[S(Ee),s("main",null,[s("div",Ne,[S(A1),S(o,{class:"mt-3"})])])])])}}});export{je as default};
