<script type="text/javascript">
    var ueDataLayer = ueDataLayer || {};
    ueDataLayer.be_page_url= document.location.href.split("?")[0];
    ueDataLayer.be_page_url_qs= document.location.href;
    ueDataLayer.be_page_article_title= document.title;
    ueDataLayer.be_page_section= document.location.pathname == "/" ? "home" : document.location.pathname.split("/")[1];
    ueDataLayer.be_page_subsection1= typeof document.location.pathname.split("/")[2] == "undefined" ? "" : document.location.pathname.split("/")[2];
    ueDataLayer.be_page_subsection2= typeof document.location.pathname.split("/")[3] == "undefined" ? "" : document.location.pathname.split("/")[3];
    ueDataLayer.be_page_subsection3= typeof document.location.pathname.split("/")[4] == "undefined" ? "" : document.location.pathname.split("/")[4];
    ueDataLayer.be_page_subsection4= typeof document.location.pathname.split("/")[5] == "undefined" ? "" : document.location.pathname.split("/")[5];
    ueDataLayer.be_page_subsection5= typeof document.location.pathname.split("/")[6] == "undefined" ? "" : document.location.pathname.split("/")[6];
    ueDataLayer.be_page_subsection6= typeof document.location.pathname.split("/")[7] == "undefined" ? "" : document.location.pathname.split("/")[7];
    ueDataLayer.be_page_domain="{{ $campaign->partner->url }}";
    ueDataLayer.be_page_subdomain= "{{ $campaign->folder }}";
    ueDataLayer.be_page_hierarchy= ueDataLayer.be_page_domain + "|" + ueDataLayer.be_page_subdomain + "|" + ueDataLayer.be_page_section + "|" + ueDataLayer.be_page_subsection1 + "|" + ueDataLayer.be_page_subsection2 + "|" + ueDataLayer.be_page_subsection3 + "|" + ueDataLayer.be_page_subsection4 + "|" + ueDataLayer.be_page_subsection5 + "|" + ueDataLayer.be_page_subsection6;
    ueDataLayer.be_text_seoTags="tag1|tag2|tag3";
    ueDataLayer.be_page_site_version="";
    ueDataLayer.be_page_cms_template="otros - {{ $campaign->name }}";
    ueDataLayer.be_page_content_type="otros";
    ueDataLayer.be_navigation_type="origen"
    ueDataLayer.be_content_premium_detail="abierto";
    ueDataLayer.be_content_premium="0";
    ueDataLayer.be_content_signwall_detail="abierto";
    ueDataLayer.be_content_signwall="0";

    (function(a,b,c,d){
        a='https://tags.tiqcdn.com/utag/unidadeditorial/{{ $domain }}/prod/utag.js';
        b=document;c='script';d=b.createElement(c);d.src=a;d.type='text/java'+c;d.async=true;
        a=b.getElementsByTagName(c)[0];a.parentNode.insertBefore(d,a);
        })();
</script>