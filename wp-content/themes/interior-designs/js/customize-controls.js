( function( api ) {

	// Extends our custom "interior-designs" section.
	api.sectionConstructor['interior-designs'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );