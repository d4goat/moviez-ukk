import{u as p}from"./hooks-BxjXLzY_.js";import{h,j as t,$ as o,w as _,a0 as b,O as v,A as g,x as a,H as w,e as x,y,Z as R,K as k,l as C,G as B,m as F,p as N}from"./main-B8dzZHEF.js";const V={class:"border-b border-body pb-3"},$={class:"w-full h-full flex flex-col rounded-lg space-y-4"},q={class:"border-b border-body flex items-center p-4"},A={class:"text-xl"},D={class:"w-full h-full py-2 px-4"},G=h({__name:"Index",setup(H){const e=R(),r=t(null),n=t(""),c=t(!1),l=k();C();const{delete:i}=p({onSuccess:r.value?.refetch()}),d=[e.accessor("no",{header:"No"}),e.accessor("film.title",{header:"Film"}),e.accessor("user.name",{header:"User"}),e.accessor("rating",{header:"Rating"}),e.accessor("review",{header:"Review"}),e.accessor("uuid",{header:"Action",cell:s=>o("div",{class:"flex gap-4"},[o("button",{class:"btn btn-md bg-red-600 hover:bg-red-700",onClick:()=>i(`/master/review/${s.getValue()}`)},[o("i",{class:"fa fa-trash fs-2"})])])})];_(c,s=>{s||(n.value=""),window.scrollTo(0,0)});const{data:u,isLoading:K,refetch:f}=b({queryKey:["films"],queryFn:async()=>B.get(`/master/film/${l.params.uuid}`).then(s=>s.data.data)});return v(()=>f()),(s,S)=>{const m=F("paginate");return N(),g("main",V,[a("div",$,[a("div",q,[a("h2",A,w(x(u)?.title)+" Reviews ",1)]),a("div",D,[y(m,{ref_key:"paginateRef",ref:r,id:"table-reviews",url:"/master/review",columns:d},null,512)])])])}}});export{G as default};
