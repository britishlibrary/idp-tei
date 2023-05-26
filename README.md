# idp-tei
TEI in International Dunhuang Project 


### Overview
Withiin the IDP system, TEI XML is used for Catalogues (including Translations) and Bibliographies. The TEI XML is stored within binary blobs within the 4D database in tables [Catatalogue] and [Bibliography] respectively. 4D methods are used to call to transform elements of the TEI from the blobs into HTML for display in panels on the website.

In this repo we store the complete set of TEI files extracted from the binary blobs. We also store copies of the various XSL stylesheets used for converting these to HTML.
