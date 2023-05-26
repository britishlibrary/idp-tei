<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">

    <!-- This stylesheet is used for displaying catalogue entries in the main catalogue page and the object overview page -->

    <xsl:output method="html"></xsl:output>
    <xsl:preserve-space elements="*"></xsl:preserve-space>

    <!-- Templates for ordered elements that structure a catalogue entry: -->

    <xsl:template match="head"></xsl:template>
    <xsl:template match="teiHeader"></xsl:template>
    <xsl:template match="msDescription">
        <xsl:apply-templates></xsl:apply-templates>
        <xsl:element name="br"></xsl:element>
        <xsl:for-each select="@type">
            <span class="smaller">(<xsl:value-of select="."></xsl:value-of>) </span>
        </xsl:for-each>
        <xsl:element name="br"></xsl:element>
    </xsl:template>
    <xsl:template match="msDescription/@n"></xsl:template>
    <xsl:template match="msDescription/@type"></xsl:template>
    <xsl:template match="msDescription/msIdentifier"></xsl:template>
    <xsl:template match="msDescription/msContents/msItem">
        <span class="notheader">
            <xsl:text>Section: </xsl:text>
            <xsl:value-of select="@n"></xsl:value-of>
        </span>
        <xsl:element name="br"></xsl:element>
        <xsl:apply-templates></xsl:apply-templates>
        <xsl:element name="br"></xsl:element>
    </xsl:template>
    <xsl:template match="msDescription/msContents/msItem/title" priority="+1">
        <xsl:if test="normalize-space(.)">
            <xsl:choose>
                <xsl:when test="@lang = 'chi-Hant' ">
                    <xsl:value-of select="."></xsl:value-of>
                </xsl:when>
                <xsl:otherwise>
                    <span class="bibit">
                        <xsl:value-of select="."></xsl:value-of>
                    </span>
                </xsl:otherwise>
            </xsl:choose>
            <xsl:element name="br"></xsl:element>
        </xsl:if>

    </xsl:template>
    <xsl:template match="msDescription/msContents/title" priority="+1">
        <xsl:choose>
            <xsl:when test="normalize-space(.)">
                <span class="bibit">
                    <xsl:apply-templates></xsl:apply-templates>
                </span>
                <xsl:element name="br"></xsl:element>
            </xsl:when>
        </xsl:choose>
    </xsl:template>
    <xsl:template match="msDescription/msContents/msItem/author">
        <xsl:choose>
            <xsl:when test="normalize-space(.)">
                <span class="notheader">Author: </span>
                <xsl:apply-templates></xsl:apply-templates>
                <xsl:element name="br"></xsl:element>
            </xsl:when>
        </xsl:choose>
    </xsl:template>
    <xsl:template match="msDescription/msContents/msItem/incipit">
        <xsl:choose>
            <xsl:when test="normalize-space(.)">
                <span class="notheader">Incipit (<xsl:value-of select="locus"></xsl:value-of>): </span>
                <xsl:apply-templates></xsl:apply-templates>
                <xsl:element name="br"></xsl:element>
            </xsl:when>
        </xsl:choose>
    </xsl:template>
    <xsl:template match="msDescription/msContents/msItem/explicit">
        <xsl:choose>
            <xsl:when test="normalize-space(.)">
                <span class="notheader">Explicit (<xsl:value-of select="locus"></xsl:value-of>): </span>
                <xsl:apply-templates></xsl:apply-templates>
                <xsl:element name="br"></xsl:element>
            </xsl:when>
        </xsl:choose>
    </xsl:template>
    <xsl:template match="msDescription/msContents/msItem/colophon">
        <xsl:choose>
            <xsl:when test="normalize-space(.)">
                <span class="notheader">Colophon (<xsl:value-of select="locus"></xsl:value-of>): </span>
                <xsl:apply-templates></xsl:apply-templates>
                <xsl:element name="br"></xsl:element>
            </xsl:when>
        </xsl:choose>
    </xsl:template>
    <xsl:template match="msDescription/msContents/note" priority="+1">
        <xsl:apply-templates></xsl:apply-templates>
        <xsl:element name="br"></xsl:element>
    </xsl:template>
    <xsl:template match="msDescription/msContents/msItem/note" priority="+1">
        <xsl:apply-templates></xsl:apply-templates>
        <xsl:element name="br"></xsl:element>
    </xsl:template>
    <xsl:template match="msDescription/msContents/msItem/q" priority="+1">
        <xsl:if test="@type">
            <span class="notheader"><xsl:value-of select="@type"></xsl:value-of>:</span>
            <xsl:element name="br"></xsl:element>
        </xsl:if>
        <xsl:apply-templates></xsl:apply-templates>
        <xsl:element name="br"></xsl:element>
    </xsl:template>
    <xsl:template match="msDescription/msContents/msItem/div">
        <span class="notheader">
            <xsl:value-of select="@n"></xsl:value-of>
            <xsl:text>: </xsl:text>
            <xsl:value-of select="@type"></xsl:value-of>
        </span>
        <xsl:element name="br"></xsl:element>
        <xsl:apply-templates></xsl:apply-templates>
    </xsl:template>
    <xsl:template match="msDescription/msContents/msItem/listBibl">
        <span class="notheader">Bibliography:<xsl:element name="br"></xsl:element></span>
        <xsl:for-each select="bibl">
            <xsl:if test="locus">
                <xsl:value-of select="locus"></xsl:value-of>
                <xsl:text>: </xsl:text>
            </xsl:if>
            <xsl:element name="a">
                <xsl:attribute name="href">/database/bibliography.a4d?shortref=<xsl:value-of
                        select="ref/@target"></xsl:value-of></xsl:attribute>
                <xsl:attribute name="onClick"
                    >popUpII(this.href,'elastic',400,600,'bibliographywin');return
                    false;</xsl:attribute>
                <xsl:choose>
                    <xsl:when test="normalize-space(.)">
                        <xsl:value-of select="ref/@target"></xsl:value-of>: <xsl:value-of
                            select="ref"></xsl:value-of>
                    </xsl:when>
                    <xsl:otherwise>
                        <xsl:value-of select="ref/@target"></xsl:value-of>
                    </xsl:otherwise>
                </xsl:choose>
            </xsl:element>
            <xsl:if test="@type">
                <xsl:text> (</xsl:text>
                <xsl:value-of select="@type"></xsl:value-of>
                <xsl:text>)</xsl:text>
            </xsl:if>
            <xsl:element name="br"></xsl:element>
        </xsl:for-each>
    </xsl:template>

    <!-- templates for <p> and <q> elements for structuring text, inside the note element or nested within each other: -->

    <xsl:template match="p">
        <xsl:apply-templates></xsl:apply-templates>
        <xsl:element name="br"></xsl:element>
    </xsl:template>
    <xsl:template match="p/q">
        <xsl:apply-templates></xsl:apply-templates>
    </xsl:template>
    <xsl:template match="note/q">
        <xsl:apply-templates></xsl:apply-templates>
        <xsl:element name="br"></xsl:element>
    </xsl:template>
    <xsl:template match="div/q">
        <xsl:apply-templates></xsl:apply-templates>
        <xsl:element name="br"></xsl:element>
    </xsl:template>

    <xsl:template match="q/locus"> (<xsl:value-of select="."></xsl:value-of>) </xsl:template>
    <xsl:template match="p/locus">
        <xsl:value-of select="."></xsl:value-of>
    </xsl:template>

    <!-- Basic intellectual content elements: name, title and term: -->

    <xsl:template match="name">
        <xsl:apply-templates></xsl:apply-templates>
    </xsl:template>
    <xsl:template match="title">
        <xsl:choose>
            <xsl:when test="@lang = 'chi-Hant' ">
                <xsl:apply-templates></xsl:apply-templates>
            </xsl:when>
            <xsl:otherwise>
                <span class="bibit">
                    <xsl:apply-templates></xsl:apply-templates>
                </span>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>
    <xsl:template match="term">
        <xsl:choose>
            <xsl:when test="@lang = 'chi' ">
                <xsl:apply-templates></xsl:apply-templates>
            </xsl:when>
            <xsl:otherwise>
                <span class="bibit">
                    <xsl:apply-templates></xsl:apply-templates>
                </span>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>

    <!-- Links to URLs and references to bibliography: -->

    <xsl:template match="link">
        <xsl:element name="a">
            <xsl:attribute name="href">
                <xsl:value-of select="@url"></xsl:value-of>
            </xsl:attribute>
            <xsl:attribute name="target">_blank</xsl:attribute>
            <xsl:apply-templates> </xsl:apply-templates>
        </xsl:element>
    </xsl:template>
    <xsl:template match="ref">
        <xsl:element name="a">
            <xsl:attribute name="href">/database/bibliography.a4d?shortref=<xsl:value-of
                    select="ref/@target"></xsl:value-of></xsl:attribute>
            <xsl:attribute name="onClick"
                >popUpII(this.href,'elastic',400,600,'bibliographywin');return
                false;</xsl:attribute>
            <xsl:choose>
                <xsl:when test="normalize-space(.)">
                    <xsl:value-of select="@target"></xsl:value-of>: <xsl:value-of select="."
                    ></xsl:value-of>
                </xsl:when>
                <xsl:otherwise>
                    <xsl:value-of select="@target"></xsl:value-of>
                </xsl:otherwise>
            </xsl:choose>
        </xsl:element>
    </xsl:template>

    <!-- Elements for text editions: -->

    <xsl:template match="del">
        <strike>
            <xsl:value-of select="."></xsl:value-of>
        </strike>
    </xsl:template>
    <xsl:template match="sic">
        <xsl:value-of select="."></xsl:value-of> [sic]</xsl:template>
    <xsl:template match="add">+<xsl:value-of select="."></xsl:value-of>
    </xsl:template>
    <xsl:template match="unclear">{<xsl:value-of select="."></xsl:value-of>}</xsl:template>
    <xsl:template match="emph">
        <span class="bibit">
            <xsl:value-of select="."></xsl:value-of>
        </span>
    </xsl:template>

    <!-- Line and page breaks (line and page numbers are optional for lb, lg, l and pb): -->

    <xsl:template match="lb">
        <xsl:if test="@n">
            <xsl:text>l.</xsl:text>
            <xsl:value-of select="@n"></xsl:value-of>
            <xsl:text>: </xsl:text>
        </xsl:if>
        <xsl:element name="br"></xsl:element>
    </xsl:template>
    <xsl:template match="lg">
        <xsl:element name="p">
            <xsl:apply-templates></xsl:apply-templates>
        </xsl:element>
    </xsl:template>
    <xsl:template match="l">
        <xsl:if test="@n">
            <xsl:text>l.</xsl:text>
            <xsl:value-of select="@n"></xsl:value-of>
            <xsl:text>: </xsl:text>
        </xsl:if>
        <xsl:apply-templates></xsl:apply-templates>
        <xsl:element name="br"></xsl:element>
    </xsl:template>
    <xsl:template match="pb">
        <xsl:element name="p">
            <xsl:if test="@n">
                <xsl:text>(</xsl:text>
                <xsl:value-of select="@n"></xsl:value-of>
                <xsl:text>) </xsl:text>
            </xsl:if>
            <xsl:value-of select="."></xsl:value-of>
        </xsl:element>
    </xsl:template>

    <!-- Footnotes and interlinear notes: -->

    <xsl:template match="note[@type='footnote']">
        <xsl:choose>
            <xsl:when test="@n">
                <span class="smaller">
                    <xsl:text> [note </xsl:text>
                    <xsl:value-of select="@n"></xsl:value-of>
                    <xsl:text>: </xsl:text>
                    <xsl:value-of select="."></xsl:value-of>
                    <xsl:text>] </xsl:text>
                </span>
                <xsl:element name="br"></xsl:element>
            </xsl:when>
            <xsl:otherwise>
                <span class="smaller">[note: <xsl:value-of select="."></xsl:value-of>]</span>
                <xsl:element name="br"></xsl:element>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>
    <xsl:template match="p/note">
        <xsl:choose>
            <xsl:when test="@n">
                <span class="smaller">
                    <xsl:text> [note </xsl:text>
                    <xsl:value-of select="@n"></xsl:value-of>
                    <xsl:text>: </xsl:text>
                    <xsl:value-of select="."></xsl:value-of>
                    <xsl:text>] </xsl:text>
                </span>
            </xsl:when>
            <xsl:otherwise>
                <span class="smaller">
                    <xsl:text> [note: </xsl:text>
                    <xsl:value-of select="."></xsl:value-of>
                    <xsl:text>] </xsl:text>
                </span>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>
    <xsl:template match="q/note">
        <xsl:choose>
            <xsl:when test="@n">
                <span class="smaller">
                    <xsl:text> [note </xsl:text>
                    <xsl:value-of select="@n"></xsl:value-of>
                    <xsl:text>: </xsl:text>
                    <xsl:value-of select="."></xsl:value-of>
                    <xsl:text> [note </xsl:text>
                </span>
            </xsl:when>
            <xsl:otherwise>
                <span class="smaller">
                    <xsl:text> [note: </xsl:text>
                    <xsl:value-of select="."></xsl:value-of>
                    <xsl:text>] </xsl:text>
                </span>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>

    <!-- Empty templates for the locus element (so content will not appear twice): -->

    <xsl:template match="incipit/locus"></xsl:template>
    <xsl:template match="explicit/locus"></xsl:template>
    <xsl:template match="colophon/locus"></xsl:template>
    <xsl:template match="locus"></xsl:template>

</xsl:stylesheet>
