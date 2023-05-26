# International Dunhuang Project - TEI repository

Github repo: **britishlibrary/idp-tei**

Public home page: [https://britishlibrary.github.io/idp-tei](https://britishlibrary.github.io/idp-tei)

Private repo on Github (invited contributors only): [https://github.com/britishlibrary/idp-tei](https://github.com/britishlibrary/idp-tei)

Wiki Home page on Github (invited contributors only): [https://github.com/britishlibrary/idp-tei/wiki/IDP-TEI-Wiki-home](https://github.com/britishlibrary/idp-tei/wiki/IDP-TEI-Wiki-home)


### Overview
Within the IDP system, TEI XML is used for Catalogues (including Translations) and Bibliographies. The TEI XML is stored within binary blobs within the 4D database in tables [Catatalogue] and [Bibliography] respectively. 4D methods are used to call to transform elements of the TEI from the blobs into HTML for display in panels on the website.

In this repo we store the complete set of (prettified) TEI files extracted from the binary blobs, [Catalogue]XMLBlob and [Bibliography]XMLRecord. For link to an index for each see Wiki page [./wiki/TEI-XML-files-extracted-from-4D-blobs](https://github.com/britishlibrary/idp-tei/wiki/TEI-XML-files-extracted-from-4D-blobs)

We also store copies of the various XSL stylsheets (version 1.0) used within the 4D system for converting these to HTML on the IDP website [idp.bl.uk](idp.bl.uk). For a Wiki page see [./wiki/XSL-stylesheets] (https://github.com/britishlibrary/idp-tei/wiki/XSL-stylesheets)
