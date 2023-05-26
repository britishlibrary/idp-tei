<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:template match="TEI.2/teiHeader"></xsl:template>
    <xsl:template match="TEI.2/text/head"></xsl:template>
    <xsl:template match="TEI.2/text/body">
        <xsl:element name="Table">
            <xsl:attribute name="id">catno_item</xsl:attribute>
            <xsl:attribute name="cellspacing">0</xsl:attribute>
            <xsl:attribute name="cellpadding">0</xsl:attribute>
            <xsl:for-each select="msDescription">
                <xsl:element name="tr">
                    <xsl:element name="td">
                        <xsl:attribute name="class">catno</xsl:attribute>
                        <xsl:element name="a">
                            <xsl:attribute name="href">javascript:;</xsl:attribute>
                            <xsl:attribute name="onClick">loadCatalogueNumber('<xsl:value-of
                                    select="@n"></xsl:value-of>')</xsl:attribute>
                            <span class="notheader">
                                <xsl:value-of select="@n"></xsl:value-of>
                            </span>
                        </xsl:element>
                    </xsl:element>
                    <xsl:element name="td">
                        <xsl:attribute name="class">item</xsl:attribute>
                        <xsl:for-each select="msIdentifier/idno">
                            <xsl:choose>
                                <xsl:when test="@type='current'">
                                    <xsl:element name="a">
                                        <xsl:attribute name="href">oo_loader.a4d?pm=<xsl:value-of
                                                select="."></xsl:value-of></xsl:attribute>
                                        <xsl:value-of select="."></xsl:value-of>
                                    </xsl:element>
                                    <xsl:element name="br"></xsl:element>
                                </xsl:when>
                                <xsl:otherwise>
                                    <xsl:value-of select="."></xsl:value-of>
                                    <xsl:element name="br"></xsl:element>
                                </xsl:otherwise>
                            </xsl:choose>
                        </xsl:for-each>
                    </xsl:element>
                </xsl:element>
            </xsl:for-each>
        </xsl:element>
    </xsl:template>
    <xsl:template match="msIdentifier"></xsl:template>
    <xsl:template match="msContents"></xsl:template>
</xsl:stylesheet>
