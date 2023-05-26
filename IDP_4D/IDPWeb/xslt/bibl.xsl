<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"></xsl:output>
    <xsl:strip-space elements="bibl"></xsl:strip-space>
    <xsl:template match="bibl">
        <xsl:apply-templates></xsl:apply-templates>
        <xsl:text>. </xsl:text>
        <br></br>
    </xsl:template>
    <xsl:template match="bibl/author">
        <xsl:value-of select="."></xsl:value-of>
        <xsl:text>, </xsl:text>
    </xsl:template>
    <xsl:template match="bibl/editor">
        <xsl:value-of select="."></xsl:value-of>
        <xsl:text> (ed.), </xsl:text>
    </xsl:template>
    <xsl:template match="bibl/respStmt">
        <xsl:choose>
            <xsl:when test="@type">
                <xsl:value-of select="."></xsl:value-of>
                <xsl:text> (</xsl:text>
                <xsl:value-of select="@type"></xsl:value-of>
                <xsl:text>), </xsl:text>
            </xsl:when>
            <xsl:otherwise>
                <xsl:value-of select="."></xsl:value-of>
                <xsl:text> (contributor), </xsl:text>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>
    <xsl:template match="bibl/title[@level='m']">
        <span class="bibit">
            <xsl:apply-templates></xsl:apply-templates>
        </span>
        <xsl:text>. </xsl:text>
    </xsl:template>
    <xsl:template match="bibl/title[@level='j']">
        <span class="bibit">
            <xsl:apply-templates></xsl:apply-templates>
        </span>
        <xsl:text>. </xsl:text>
    </xsl:template>
    <xsl:template match="bibl/title[@level='e']">
        <span class="bibit">
            <xsl:apply-templates></xsl:apply-templates>
        </span>
        <xsl:text> [Electronic publication]. </xsl:text>
    </xsl:template>
    <xsl:template match="bibl/title[@level='a']">
        <xsl:text>'</xsl:text>
        <xsl:apply-templates></xsl:apply-templates>
        <xsl:text>'</xsl:text>
        <xsl:text>. </xsl:text>
    </xsl:template>
    <xsl:template match="bibl/title[@level='u']">
        <xsl:text>'</xsl:text>
        <xsl:apply-templates></xsl:apply-templates>
        <xsl:text>' (</xsl:text>
        <xsl:value-of select="../note"></xsl:value-of>
        <xsl:text>)</xsl:text>
    </xsl:template>

    <!--template for <imprint> below deals with 3 types of imprint: monograph, journal and series (there is no <imprint> for unpublished (type="u") books-->

    <xsl:template match="bibl/imprint">
        <xsl:if test="title[@level='m']">
            <xsl:choose>
                <xsl:when test="title[@type='shortRef']">
                    <xsl:text>In </xsl:text>
                    <xsl:element name="a">
                        <xsl:attribute name="href"
                                >/database/bibliography_loader.a4d?shortref=<xsl:value-of
                                select="../../bibl/@shortRef"></xsl:value-of></xsl:attribute>
                        <xsl:attribute name="onClick"
                            >popUpII(this.href,'fixed',400,600,'bibliographywin');return false;</xsl:attribute>
                        <xsl:value-of select="title"></xsl:value-of>
                    </xsl:element>
                </xsl:when>
                <xsl:otherwise>
                    <xsl:text>In </xsl:text>
                    <span class="bibit">
                        <xsl:value-of select="title"></xsl:value-of>
                    </span>
                    <xsl:text>. </xsl:text>
                    <xsl:if test="title[@level='s']">
                        (<xsl:value-of select="series"></xsl:value-of>
                        <xsl:text> </xsl:text>
                        <xsl:value-of select="biblScope"></xsl:value-of>
                        <xsl:text>.) </xsl:text>
                    </xsl:if>
                    <xsl:if test="editor">
                        <xsl:value-of select="editor"></xsl:value-of>
                        <xsl:text> (ed.), </xsl:text>
                    </xsl:if>
                    <xsl:value-of select="pubPlace"></xsl:value-of>
                    <xsl:text>: </xsl:text>
                    <xsl:value-of select="publisher"></xsl:value-of>
                    <xsl:text>, </xsl:text>
                    <xsl:value-of select="date"></xsl:value-of>
                </xsl:otherwise>
            </xsl:choose>
        </xsl:if>
        <xsl:if test="title[@level='j']">
            <xsl:choose>
                <xsl:when test="title[@type='shortRef']">
                    <xsl:element name="a">
                        <xsl:attribute name="href"
                                >/database/bibliography_loader.a4d?shortref=<xsl:value-of
                                select="../../bibl/@shortRef"></xsl:value-of></xsl:attribute>
                        <xsl:attribute name="onClick"
                            >popUpII(this.href,'fixed',400,600,'bibliographywin');return false;</xsl:attribute>
                        <xsl:value-of select="title"></xsl:value-of>
                    </xsl:element>
                    <xsl:text> </xsl:text>
                    <xsl:value-of select="biblScope[@type='issue']"></xsl:value-of>
                    <xsl:text> (</xsl:text>
                    <xsl:value-of select="date"></xsl:value-of>
                    <xsl:text>): </xsl:text>
                    <xsl:value-of select="biblScope[@type='pp']"></xsl:value-of>
                </xsl:when>
                <xsl:otherwise>
                    <span class="bibit">
                        <xsl:value-of select="title"></xsl:value-of>
                    </span>
                    <xsl:text> </xsl:text>
                    <xsl:value-of select="biblScope[@type='issue']"></xsl:value-of>
                    <xsl:text> (</xsl:text>
                    <xsl:value-of select="date"></xsl:value-of>
                    <xsl:text>): </xsl:text>
                    <xsl:value-of select="biblScope[@type='pp']"></xsl:value-of>
                </xsl:otherwise>
            </xsl:choose>
        </xsl:if>
        <xsl:if test="title[@level='s']">
            <xsl:text>In </xsl:text>
            <span class="bibit">
                <xsl:value-of select="title"></xsl:value-of>
            </span>
            <xsl:text>. </xsl:text>
            <xsl:value-of select="pubPlace"></xsl:value-of>
            <xsl:text>: </xsl:text>
            <xsl:value-of select="publisher"></xsl:value-of>
            <xsl:text>, </xsl:text>
            <xsl:value-of select="date"></xsl:value-of>
        </xsl:if>
        <xsl:if test="not(title)">
            <xsl:value-of select="pubPlace"></xsl:value-of>
            <xsl:text>: </xsl:text>
            <xsl:value-of select="publisher"></xsl:value-of>
            <xsl:text>, </xsl:text>
            <xsl:value-of select="date"></xsl:value-of>
        </xsl:if>
    </xsl:template>

    <!--empty templates to prevent element content within <imprint> appearing more than once-->
    <xsl:template match="bibl/imprint/title"> </xsl:template>
    <xsl:template match="bibl/imprint/author"> </xsl:template>
    <xsl:template match="bibl/imprint/editor"> </xsl:template>
    <xsl:template match="bibl/imprint/pubPlace"> </xsl:template>
    <xsl:template match="bibl/imprint/publisher"> </xsl:template>
    <xsl:template match="bibl/imprint/date"> </xsl:template>
    <xsl:template match="bibl/imprint/idno"></xsl:template>
    <xsl:template match="biblScope"> </xsl:template>
    <xsl:template match="bibl/imprint/edition"> </xsl:template>
    <xsl:template match="bibl/imprint/edition/date"> </xsl:template>
    <xsl:template match="keywords"></xsl:template>
    <xsl:template match="genBibl"></xsl:template>
    <xsl:template match="note"></xsl:template>
</xsl:stylesheet>
