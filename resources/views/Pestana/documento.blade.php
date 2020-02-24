<style>
*{
    margin:0;
}

.embed-container {
    position: relative;
    padding-bottom: 56.25%;
    height: 0;
    overflow: hidden;
}
.embed-container iframe {
    position: absolute;
    top:0;
    left: 0;
    width: 100%;
    height: 100%;
}

</style>
<!--Inestable-->
<div class="embed-container">
    <iframe src="../docs/{{$ruta}}" frameborder="0" allowfullscreen></iframe>
</div>