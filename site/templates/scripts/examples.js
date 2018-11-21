/* =============================================================
   URI.JS
 ============================================================ */
    var url = new URI("http://example.org/foo?bar=baz");
    url.addQuery("bar", "foo"); //http://example.org/foo?bar=baz&bar=foo
    url.search(function(data) {
        return { bar : "" };
    }); //http://example.org/foo?bar=
    url.normalizeQuery();
    console.log(url.toString());
