@extends('layouts.app')

@section('title','Términos y condiciones')
@section('meta_description','Lee los términos y condiciones de uso de Academia Ariete: condiciones de uso, propiedad intelectual, devoluciones, privacidad y jurisdicción.')

@section('content')
@php
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Facades\Route;
@endphp

<section class="panel-page py-6" id="terminos-condiciones">
  <div class="container">

    {{-- Breadcrumb --}}
    <nav class="mb-4 text-sm text-slate-600" aria-label="Breadcrumb">
      <ol class="flex flex-wrap items-center gap-1">
        <li>
          <a href="{{ route('inicio') }}" class="hover:underline">
            Inicio
          </a>
        </li>
        <li aria-hidden="true">/</li>
        <li aria-current="page" class="text-slate-800 font-medium">
          Términos y condiciones
        </li>
      </ol>
    </nav>

    <h1 class="titulo">Términos y condiciones</h1>

    {{-- MARCO / TARJETA --}}
    <div class="mt-4 rounded-xl border border-slate-200 bg-white p-5 md:p-6 shadow-sm">
      <div class="prose prose-slate max-w-none">
        <p class="text-slate-500 mb-4">
          <strong>Los términos y condiciones se actualizaron por última vez el 14 de mayo de 2025</strong>
        </p>

        <h2 class="subtitulo">1. Introducción</h2>
        <p>
          Estos Términos y condiciones se aplican a este sitio web y a las transacciones relacionadas con nuestros productos y servicios. Usted puede 
          estar obligado por contratos adicionales relacionados con su relación con nosotros o con cualquier producto o servicio que reciba de nosotros. 
          Si alguna de las disposiciones de los contratos adicionales entra en conflicto con alguna de las disposiciones de estas Condiciones, las 
          disposiciones de estos contratos adicionales prevalecerán.
        </p>

        <h2 class="subtitulo">2. Vinculación</h2>
        <p>
          Al registrarse en este sitio web, acceder a él o utilizarlo de cualquier otro modo, usted acepta someterse a las condiciones que se exponen a 
          continuación. El mero uso de este sitio web implica el conocimiento y la aceptación de estos Términos y condiciones. En algunos casos 
          particulares, también podemos pedirle que lo acepte explícitamente.
        </p>

        <h2 class="subtitulo">3. Propiedad intelectual</h2>
        <p>
          Nosotros o nuestros licenciantes poseemos y controlamos todos los derechos de autor y otros derechos de propiedad intelectual en el sitio web, 
          y los datos, la información y otros recursos mostrados por o accesibles dentro del sitio web.
        </p>

        <h3 class="subtitulo">3.1 Todos los derechos están reservados</h3>
        <p>
          A menos que el contenido específico indique lo contrario, no se le concede una licencia ni ningún otro derecho en virtud de los derechos de 
          autor, marcas comerciales, patentes u otros derechos de propiedad intelectual. Esto significa que usted no utilizará, copiará, reproducirá, 
          ejecutará, mostrará, distribuirá, incrustará en cualquier medio electrónico, alterará, realizará ingeniería inversa, descompilará, transferirá, 
          descargará, transmitirá, monetizará, venderá, comercializará o hará uso de cualquier recurso de este sitio web en cualquier forma, sin nuestro 
          permiso previo por escrito, excepto y sólo en la medida en que se estipule lo contrario en normas de leyes obligatorias (como el derecho de 
          cita).
        </p>

        <h2 class="subtitulo">4. Propiedad de terceros</h2>
        <p>
          Nuestro sitio web puede incluir hipervínculos u otras referencias a sitios web de terceros. No controlamos ni revisamos el contenido de los 
          sitios web de terceros a los que se accede desde este sitio web. Los productos o servicios ofrecidos por otros sitios web estarán sujetos a los 
          Términos y Condiciones aplicables de esos terceros. Las opiniones expresadas o el material que aparece en esos sitios web no son necesariamente 
          compartidas o respaldadas por nosotros.
        </p>
        <p>
          No seremos responsables de las prácticas de privacidad o del contenido de estos sitios. Usted asume todos los riesgos asociados al uso de estos 
          sitios web y de cualquier servicio de terceros relacionado. No aceptaremos ninguna responsabilidad por cualquier pérdida o daño, sea cual sea la 
          forma en que se produzca, que resulte de la divulgación por su parte de información personal a terceros.
        </p>

        <h2 class="subtitulo">5. Uso responsable</h2>
        <p>
          Al visitar nuestro sitio web, usted se compromete a utilizarlo sólo para los fines previstos y según lo permitido por estos Términos, cualquier 
          contrato adicional con nosotros, y las leyes aplicables, reglamentos y prácticas en línea generalmente aceptadas y directrices de la industria. No 
          debe usar nuestro sitio web o nuestros servicios para utilizar, publicar o distribuir cualquier material que consista en (o esté vinculado a) 
          software informático malicioso; utilizar los datos recogidos en nuestro sitio web para cualquier actividad de marketing directo, o llevar a cabo 
          cualquier actividad de recopilación de datos sistemática o automatizada en o en relación con nuestro sitio web.
        </p>
        <p>
          Está estrictamente prohibido realizar cualquier actividad que provoque o pueda provocar daños en el sitio web o que interfiera en su 
          funcionamiento, disponibilidad o accesibilidad.
        </p>

        <h2 class="subtitulo">6. Política de Devoluciones y Reembolsos</h2>
        <h3 class="subtitulo">6.1 Derecho de desistimiento</h3>
        <p>Tiene derecho a rescindir el contrato en un plazo de 14 días sin indicar el motivo.</p>

        <p>
          Para ejercer el derecho de desistimiento, debe informarnos de su decisión de desistir de este contrato mediante una declaración inequívoca
          (por ejemplo, una carta enviada por correo, fax o correo electrónico). A continuación encontrará nuestros datos de contacto.
          @if(Route::has('descargar.formulario'))
            Puede utilizar el modelo adjunto de
            <a href="{{ route('descargar.formulario') }}" class="link-underline font-semibold" style="color: var(--arietehover);">
              formulario de desistimiento
            </a>,
            pero no es obligatorio.
          @else
            Puede utilizar el modelo oficial de formulario de desistimiento previsto en la normativa de consumo, aunque su uso no es obligatorio.
          @endif
        </p>

        <p>
          También puede rellenar y presentar electrónicamente el modelo de formulario de desistimiento o cualquier otra declaración inequívoca 
          en nuestro 
          <a href="{{ route('contacto') }}" class="link-underline font-semibold" target="_blank" rel="noopener" style="color: var(--arietehover);">
            sitio web
          </a>.
          Si utiliza esta opción, le comunicaremos sin demora un acuse de recibo de dicho desistimiento en un soporte duradero (por ejemplo, por correo 
          electrónico).
        </p>

        <p>
          Para cumplir el plazo de desistimiento, basta con que envíe su comunicación sobre el ejercicio del derecho de desistimiento antes de que expire 
          el plazo de desistimiento.
        </p>

        <h3 class="subtitulo">6.2 Consecuencias de la retirada</h3>
        <p>
          Si rescinde el contrato, le reembolsaremos todos los pagos que hayamos recibido, incluidos los gastos de entrega (a excepción de los gastos 
          suplementarios resultantes de su elección de un tipo de entrega distinto al tipo de entrega estándar menos costoso que ofrezcamos), sin ninguna 
          demora indebida y, en cualquier caso, a más tardar en 14 días a partir del día en que se nos informe de su decisión de rescindir el contrato. 
          Realizaremos dicho reembolso utilizando el mismo medio de pago que usted utilizó para la transacción inicial, a menos que haya acordado 
          expresamente lo contrario; en cualquier caso, usted no incurrirá en ninguna comisión como resultado de dicho reembolso.
        </p>
        <p>
          Usted sólo es responsable de la disminución del valor de los bienes resultante de una manipulación distinta a la necesaria para establecer la 
          naturaleza, las características y el funcionamiento de los bienes.
        </p>
        <p>
          Por favor, tenga en cuenta que hay algunas excepciones legales al derecho de desistimiento y, por tanto, algunos artículos no se pueden devolver 
          o cambiar. Le informaremos si esto se aplica a su caso particular.
        </p>

        <h2 class="subtitulo">7. Envío de ideas</h2>
        <p>
          No envíe ideas, inventos, trabajos de autoría u otra información que pueda considerarse su propia propiedad intelectual y que le gustaría 
          presentarnos, a menos que primero hayamos firmado un acuerdo con respecto a la propiedad intelectual o un acuerdo de no divulgación. Si nos lo 
          comunica en ausencia de dicho acuerdo por escrito, nos concede una licencia mundial, irrevocable, no exclusiva y libre de derechos de autor para 
          utilizar, reproducir, almacenar, adaptar, publicar, traducir y distribuir su contenido en cualquier medio existente o futuro.
        </p>

        <h2 class="subtitulo">8. Terminación de uso</h2>
        <p>
          Podemos, a nuestra entera discreción, modificar o interrumpir en cualquier momento el acceso, temporal o permanentemente, al sitio web o a 
          cualquier Servicio del mismo. Usted acepta que no seremos responsables ante usted ni ante ningún tercero por cualquier modificación, suspensión o
          interrupción de su acceso o uso del sitio web o de cualquier contenido que pueda haber compartido en el sitio web. Usted no tendrá derecho a 
          ninguna compensación ni a ningún otro pago, ni siquiera si se pierden de forma permanente determinadas funciones, configuraciones y/o cualquier 
          Contenido con el que haya contribuido o en el que haya confiado. No debe eludir o evitar, o intentar eludir o evitar, cualquier medida de 
          restricción de acceso en nuestro sitio web.
        </p>

        <h2 class="subtitulo">9. Garantías y responsabilidad</h2>
        <p>
          Nada de lo dispuesto en esta sección limitará o excluirá cualquier garantía implícita por ley que fuera ilegal limitar o excluir. Este sitio 
          web y todo su contenido se proporcionan "tal cual" y "según disponibilidad" y pueden incluir inexactitudes o errores tipográficos. Renunciamos 
          expresamente a toda garantía de cualquier tipo, ya sea expresa o implícita, en cuanto a la disponibilidad, precisión o completitud del contenido.
          No garantizamos que:
        </p>
        <ul class="puntos">
          <li>Este sitio web o nuestros contenidos cumplirán con sus necesidades.</li>
          <li>Este sitio web estará disponible de forma ininterrumpida, oportuna, segura o sin errores.</li>
        </ul>
        <p>
          Nada de lo contenido en este sitio web constituye o pretende constituir un asesoramiento jurídico, financiero o médico de ningún tipo. Si 
          necesita asesoramiento, debe consultar a un profesional adecuado.
        </p>
        <p>
          Las siguientes disposiciones de esta sección se aplicarán en la medida máxima permitida por la ley aplicable y no limitarán ni excluirán 
          nuestra responsabilidad con respecto a cualquier asunto que sería ilícito o ilegal para nosotros limitar o excluir nuestra responsabilidad.  
          En ningún caso seremos responsables de cualquier daño directo o indirecto (incluyendo cualquier daño por pérdida de beneficios o ingresos, 
          pérdida o corrupción de datos, software o base de datos, o pérdida o daño a la propiedad o a los datos) incurridos por usted o por cualquier 
          tercero, que surja de su acceso o uso de nuestro sitio web.
        </p>
        <p>
          Salvo en la medida en que cualquier contrato adicional establezca expresamente lo contrario, nuestra responsabilidad máxima hacia usted por 
          todos los daños que surjan o estén relacionados con el sitio web o con cualquier producto o servicio comercializado o vendido a través del sitio 
          web, independientemente de la forma de acción legal que imponga la responsabilidad (ya sea por contrato, equidad, negligencia, conducta 
          intencionada, agravio o cualquier otra forma) se limitará al precio total que usted nos pagó para comprar dichos productos o servicios o utilizar
          el sitio web. Dicho límite se aplicará en conjunto a todas sus reclamaciones, acciones y causas de acción de cualquier tipo y naturaleza.
        </p>

        <h2 class="subtitulo">10. Privacidad</h2>
        <p>
          Para acceder a nuestro sitio web y/o servicios, es posible que se le pida que proporcione cierta información sobre usted como parte del proceso 
          de registro. Usted se compromete a que toda la información que proporcione sea siempre precisa, correcta y actualizada.
        </p>

        <h2 class="subtitulo">11. Restricciones a la exportación / Cumplimiento legal</h2>
        <p>
          Se prohíbe el acceso al sitio web desde territorios o países donde el contenido o la compra de los productos o Servicios vendidos en el sitio 
          web sea ilegal. No puede utilizar este sitio web infringiendo las leyes y reglamentos de exportación de España.
        </p>

        <h2 class="subtitulo">12. Asignación</h2>
        <p>
          Usted no puede ceder, transferir o subcontratar ninguno de sus derechos y/u obligaciones en virtud de estos Términos y condiciones, en su 
          totalidad o en parte, a ningún tercero sin nuestro consentimiento previo por escrito. Cualquier supuesta asignación en violación de esta sección 
          será nula y sin efecto.
        </p>

        <h2 class="subtitulo">13. Incumplimientos de estos Términos y condiciones</h2>
        <p>
          Sin perjuicio de los demás derechos que nos asisten en virtud de los presentes Términos y Condiciones, si usted incumple estos Términos y 
          Condiciones de cualquier manera, podremos tomar las medidas que consideremos oportunas para hacer frente al incumplimiento, incluyendo la 
          suspensión temporal o permanente de su acceso al sitio web, poniéndonos en contacto con su proveedor de servicios de Internet para solicitarle 
          que bloquee su acceso al sitio web, y/o iniciar acciones legales contra usted.
        </p>

        <h2 class="subtitulo">14. Fuerza mayor</h2>
        <p>
          Excepto en el caso de las obligaciones de pago de dinero, ningún retraso, fallo u omisión por parte de cualquiera de las partes en el 
          cumplimiento o la observancia de cualquiera de sus obligaciones en virtud del presente documento se considerará un incumplimiento de estos 
          Términos y condiciones si, y mientras, dicho retraso, fallo u omisión se deba a una causa más allá del control razonable de dicha parte.
        </p>

        <h2 class="subtitulo">15. Indemnización</h2>
        <p>
          Usted se compromete a indemnizarnos, defendernos y eximirnos de toda reclamación, responsabilidad, daños, pérdidas y gastos, relacionados con 
          la violación de estas condiciones y de las leyes aplicables, incluidos los derechos de propiedad intelectual y los derechos de privacidad. Usted 
          nos reembolsará sin demora los daños, pérdidas, costes y gastos relacionados con dichas reclamaciones o derivados de ellas.
        </p>

        <h2 class="subtitulo">16. Renuncia</h2>
        <p>
          El incumplimiento de cualquiera de las disposiciones establecidas en estos Términos y condiciones y en cualquier Acuerdo, o la falta de 
          ejercicio de cualquier opción de interrupción, no se interpretará como una renuncia a dichas disposiciones y no afectará a la validez de estos 
          Términos y Condiciones o de cualquier Acuerdo o cualquier parte del mismo, ni al derecho posterior de hacer cumplir todas y cada una de las 
          disposiciones.
        </p>

        <h2 class="subtitulo">17. Idioma</h2>
        <p>
          Estos Términos y Condiciones se interpretarán y analizarán exclusivamente en español. Todas las notificaciones y la correspondencia 
          se redactarán exclusivamente en ese idioma.
        </p>

        <h2 class="subtitulo">18. Acuerdo completo</h2>
        <p>
          Estos Términos y Condiciones constituirán el acuerdo completo entre usted y Academia Ariete en relación con su uso de este sitio web.
        </p>

        <h2 class="subtitulo">19. Actualización de los presentes Términos y Condiciones</h2>
        <p>
          Es posible que actualicemos estos Términos y Condiciones de vez en cuando. La fecha indicada al principio de estas Condiciones Generales es la 
          última fecha de revisión. Le notificaremos por escrito cualquier cambio o actualización, y los Términos y Condiciones revisados entrarán en vigor
          a partir de la fecha en que le enviemos dicha notificación. El uso continuado de este sitio web tras la publicación de cambios o actualizaciones
          se considerará un aviso de su aceptación de cumplir y estar sujeto a estos Términos y Condiciones. Para solicitar una versión anterior de 
          estos Términos y condiciones, póngase en contacto con nosotros.
        </p>

        <h2 class="subtitulo">20. Elección de ley y jurisdicción</h2>
        <p>
          Estos Términos y Condiciones se regirán por las leyes de España. Cualquier disputa relacionada con estos Términos y Condiciones estará sujeta a 
          la jurisdicción de los tribunales de España. Si un tribunal u otra autoridad considera que alguna parte o disposición de estos Términos y 
          Condiciones es inválida y/o inaplicable en virtud de la legislación vigente, dicha parte o disposición será modificada, eliminada y/o aplicada en
          la mayor medida permitida para hacer efectiva la intención de estos Términos y Condiciones. Las demás disposiciones no se verán afectadas.
        </p>

        <h2 class="subtitulo">21. Información de contacto</h2>
        <p>
          Este sitio web es propiedad y está gestionado por Academia Ariete.
        </p>
        <p>
          Puede ponerse en contacto con nosotros en relación con estos Términos y Condiciones a través de nuestra 
          <a href="{{ route('contacto') }}" class="link-underline" style="color: var(--arietehover)">
            <strong>página de contacto</strong>
          </a>.
        </p>

        <h2 class="subtitulo">22. Descargar</h2>
        @if (Storage::disk('public')->exists('legal/terminos.pdf'))
          <p>
            Puedes descargar nuestros términos y condiciones en PDF aquí:
            <a href="{{ asset('storage/legal/terminos.pdf') }}" class="link-underline" target="_blank" rel="noopener">
              Descargar PDF
            </a>.
          </p>
        @elseif(Route::has('descargar.terminos'))
          <p>
            También puedes descargar nuestros términos y condiciones como un
            <a href="{{ route('descargar.terminos') }}" class="link-underline" style="color: var(--arietehover);">
              <strong>PDF</strong>
            </a>.
          </p>
        @else
          <p>
            Si necesitas una copia en PDF de estos términos y condiciones, puedes solicitarla a través de
            <a href="{{ route('contacto') }}" class="link-underline" style="color: var(--arietehover);">
              nuestro formulario de contacto
            </a>.
          </p>
        @endif
      </div>
    </div>
  </div>
</section>
@endsection
