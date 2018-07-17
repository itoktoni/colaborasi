var client = algoliasearch('TP8H76V4RK', '2301f1d5e0f4569f9820e31d870e1aab');
var index = client.initIndex('team_product');
//initialize autocomplete on search input (ID selector must match)
$('#aa-search-input').autocomplete({
    hint: false
}, [{
    source: $.fn.autocomplete.sources.hits(index, {
        hitsPerPage: 5
    }),
    //value to be displayed in input control after user's suggestion selection
    displayKey: 'name',
    //hash of templates used when rendering dataset
    templates: {
        //'suggestion' templating function used to render a single suggestion
        suggestion: function (suggestion) {
            // return '<span>' + suggestion._highlightResult.firstname.value + '</span><span>' + suggestion._highlightResult.lastname.value + '</span>';
            return '<span>' + suggestion._highlightResult.name.value + '</span>';
        }
    }
}]).on('autocomplete:selected', function (event, suggestion, dataset) {
    window.location.href = '/product' + suggestion.slug;
    console.log(suggestion);
});