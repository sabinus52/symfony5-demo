(function()
{

    var engine = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('ip'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        //prefetch: '../data/films/post_1960.json',
        remote: {
          url: Routing.generate('autocomplete-ips', { term: 'TERM' }),
          wildcard: 'TERM'
        }
      });
      
      $('#sdSearch').typeahead(null, {
        name: 'best-pictures',
        display: 'ip',
        source: engine
      });

})();